<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\Cart;
use App\Helpers\DB;
use App\Helpers\Logger;
use PDO;
use Throwable;

final class Order
{
    public static function createFromCart(int $userId, string $name, string $phone, string $notes = ''): int
    {
        $name  = trim($name);
        $phone = trim($phone);
        $notes = trim($notes);

        if ($name === '' || mb_strlen($name) > 150) {
            throw new \InvalidArgumentException('الاسم غير صالح');
        }
        if ($phone === '' || mb_strlen($phone) > 30) {
            throw new \InvalidArgumentException('الهاتف غير صالح');
        }
        if (mb_strlen($notes) > 500) {
            throw new \InvalidArgumentException('الملاحظات طويلة جداً');
        }

        $cart = Cart::items(); // [id=>qty]
        if (empty($cart)) {
            throw new \RuntimeException('السلة فارغة');
        }

        $ids = array_keys($cart);
        $pdo = DB::pdo();

        try {
            $pdo->beginTransaction();

            // Lock inventory rows to avoid race conditions
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            $sql = "
              SELECT 
                p.id, p.name,
                i.price, i.qty AS stock_qty
              FROM products p
              INNER JOIN inventory i ON i.product_id = p.id
              WHERE p.id IN ($placeholders) AND p.is_active = 1
              FOR UPDATE
            ";

            $stmt = $pdo->prepare($sql);
            foreach ($ids as $i => $id) {
                $stmt->bindValue($i + 1, (int)$id, PDO::PARAM_INT);
            }
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($products) !== count($ids)) {
                throw new \RuntimeException('بعض المنتجات غير موجودة أو غير فعّالة');
            }

            // Validate stock + compute totals
            $total = 0.0;
            $lines = [];

            foreach ($products as $p) {
                $pid = (int)$p['id'];
                $reqQty = (int)($cart[$pid] ?? 0);
                $stock  = (int)$p['stock_qty'];

                if ($reqQty <= 0) continue;

                if ($stock < $reqQty) {
                    throw new \RuntimeException('الكمية غير متوفرة للمنتج: ' . $p['name']);
                }

                $price = (float)$p['price'];
                $lineTotal = $price * $reqQty;
                $total += $lineTotal;

                $lines[] = [
                    'product_id' => $pid,
                    'product_name' => (string)$p['name'],
                    'unit_price' => $price,
                    'qty' => $reqQty,
                    'line_total' => $lineTotal,
                ];
            }

            if (empty($lines)) {
                throw new \RuntimeException('السلة فارغة');
            }

            // Insert order
$stmt = $pdo->prepare("
  INSERT INTO orders (user_id, customer_name, customer_phone, notes, status, total)
  VALUES (:uid, :name, :phone, :notes, 'pending', :total)
");
$stmt->execute([
  ':uid'   => $userId,
  ':name'  => $name,
  ':phone' => $phone,
  ':notes' => $notes !== '' ? $notes : null,
  ':total' => round($total, 2),
]);

            $orderId = (int)$pdo->lastInsertId();

            // Insert order items
            $stmtItem = $pdo->prepare("
              INSERT INTO order_items (order_id, product_id, product_name, unit_price, qty, line_total)
              VALUES (:order_id, :product_id, :product_name, :unit_price, :qty, :line_total)
            ");

            foreach ($lines as $l) {
                $stmtItem->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $l['product_id'],
                    ':product_name' => $l['product_name'],
                    ':unit_price' => $l['unit_price'],
                    ':qty' => $l['qty'],
                    ':line_total' => round($l['line_total'], 2),
                ]);
            }

$stmtUpd = $pdo->prepare("
  UPDATE inventory
  SET qty = qty - :qty1
  WHERE product_id = :pid AND qty >= :qty2
");

foreach ($lines as $l) {
    $q = (int)$l['qty'];
    $pid = (int)$l['product_id'];

    $stmtUpd->execute([
        ':qty1' => $q,
        ':qty2' => $q,
        ':pid'  => $pid,
    ]);

    if ($stmtUpd->rowCount() !== 1) {
        throw new \RuntimeException('فشل خصم المخزون (تزامن)');
    }
}
            $pdo->commit();

            // Clear cart after success
            Cart::clear();

            return $orderId;

        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            Logger::error('Create order failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public static function find(int $orderId): ?array
    {
        $pdo = DB::pdo();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $orderId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }


    public static function listByUser(int $userId): array
{
    $pdo = DB::pdo();
    $st = $pdo->prepare("
        SELECT id, total, status, created_at
        FROM orders
        WHERE user_id = :uid
        ORDER BY id DESC
    ");
    $st->execute([':uid' => $userId]);
    return $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

public static function cancelIfPending(int $orderId, int $userId): void
{
    $pdo = DB::pdo();

    // فقط pending + لنفس المستخدم
    $st = $pdo->prepare("
        UPDATE orders
        SET status = 'cancelled'
        WHERE id = :id AND user_id = :uid AND status = 'pending'
        LIMIT 1
    ");
    $st->execute([':id' => $orderId, ':uid' => $userId]);
}

    public static function itemsByOrder(int $orderId, int $userId): array
{
    $pdo = DB::pdo();

    // تأكيد أن الطلب لهذا المستخدم
    $st = $pdo->prepare("SELECT id FROM orders WHERE id = :oid AND user_id = :uid LIMIT 1");
    $st->execute([':oid' => $orderId, ':uid' => $userId]);
    if (!$st->fetch(\PDO::FETCH_ASSOC)) return [];

    $st2 = $pdo->prepare("
        SELECT product_name, unit_price, qty, line_total
        FROM order_items
        WHERE order_id = :oid
        ORDER BY id ASC
    ");
    $st2->execute([':oid' => $orderId]);
    return $st2->fetchAll(\PDO::FETCH_ASSOC) ?: [];
}

}