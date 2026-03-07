<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Helpers\Cart;
use App\Helpers\Csrf;
use App\Helpers\Response;
use App\Models\Product;

final class CartApiController
{
    // GET /api/cart
    public function get(): void
    {
        $items = Cart::items(); // [id=>qty]
        $products = Product::byIds(array_keys($items));

        $lines = [];
        $total = 0.0;

        foreach ($products as $p) {
            $pid = (int)$p['id'];
            $qty = (int)($items[$pid] ?? 0);

            $stock = (int)$p['qty'];
            if ($qty > $stock) {
                $qty = $stock;
                Cart::setQty($pid, $qty);
            }

            $price = (float)$p['price'];
            $lineTotal = $price * $qty;
            $total += $lineTotal;

            $lines[] = [
                'id' => $pid,
                'name' => $p['name'],
                'brand' => $p['brand_name'],
                'price' => $price,
                'qty' => $qty,
                'stock' => $stock,
                'line_total' => $lineTotal,
            ];
        }

        Response::json([
            'ok' => true,
            'count' => Cart::count(),
            'total' => round($total, 2),
            'items' => $lines,
        ]);
    }

    // POST /api/cart/add  (product_id, qty, _csrf)
    public function add(): void
    {
        Csrf::verifyOrFail($_POST['_csrf'] ?? null);

        $pid = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

        if ($pid <= 0) Response::json(['ok' => false, 'message' => 'product_id invalid'], 422);

        $p = Product::byIds([$pid]);
        if (empty($p)) Response::json(['ok' => false, 'message' => 'product not found'], 404);

        $stock = (int)$p[0]['qty'];
        if ($stock <= 0) Response::json(['ok' => false, 'message' => 'out of stock'], 409);

        Cart::add($pid, $qty);

        // قص الكمية للمخزون
        $current = Cart::items()[$pid] ?? 0;
        if ($current > $stock) Cart::setQty($pid, $stock);

        Response::json([
            'ok' => true,
            'message' => 'added',
            'count' => Cart::count(),
        ]);
    }

    // POST /api/cart/update (product_id, qty, _csrf)
    public function update(): void
    {
        Csrf::verifyOrFail($_POST['_csrf'] ?? null);

        $pid = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 0;

        if ($pid <= 0) Response::json(['ok' => false, 'message' => 'product_id invalid'], 422);

        Cart::setQty($pid, $qty);
        $this->get();
    }

    // POST /api/cart/clear (_csrf)
    public function clear(): void
    {
        Csrf::verifyOrFail($_POST['_csrf'] ?? null);
        Cart::clear();
        Response::json(['ok' => true, 'count' => 0]);
    }
}