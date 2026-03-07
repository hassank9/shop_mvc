<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\DB;

final class Product
{
    private static function clampLimit(int $limit): int
    {
        // حماية بسيطة: limit داخلي فقط (مو من المستخدم)
        if ($limit < 1) return 1;
        if ($limit > 60) return 60;
        return $limit;
    }

    public static function latest(int $limit = 12): array
    {
        $limit = self::clampLimit($limit);

        $pdo = DB::pdo();
        $sql = "
            SELECT 
              p.id, p.name, p.slug, p.rating,
              c.name AS category_name,
              b.name AS brand_name,
              i.price, i.qty
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            LEFT JOIN brands b ON b.id = p.brand_id
            INNER JOIN inventory i ON i.product_id = p.id
            WHERE p.is_active = 1
            ORDER BY p.id DESC
            LIMIT {$limit}
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function search(string $q, int $limit = 12): array
    {
        $q = trim($q);
        $limit = self::clampLimit($limit);

        if ($q === '') return self::latest($limit);

        $pdo = DB::pdo();
        $sql = "
            SELECT 
              p.id, p.name, p.slug, p.rating,
              c.name AS category_name,
              b.name AS brand_name,
              i.price, i.qty
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            LEFT JOIN brands b ON b.id = p.brand_id
            INNER JOIN inventory i ON i.product_id = p.id
            WHERE p.is_active = 1
              AND (p.name LIKE :q1 OR b.name LIKE :q2 OR c.name LIKE :q3)
            ORDER BY p.id DESC
            LIMIT {$limit}
        ";

        $like = '%' . $q . '%';

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':q1', $like, \PDO::PARAM_STR);
        $stmt->bindValue(':q2', $like, \PDO::PARAM_STR);
        $stmt->bindValue(':q3', $like, \PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function byIds(array $ids): array
    {
        $ids = array_values(array_filter($ids, fn($x) => is_numeric($x)));
        if (empty($ids)) return [];

        $pdo = DB::pdo();

        // placeholders (?, ?, ?)
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $sql = "
            SELECT 
              p.id, p.name, p.slug,
              b.name AS brand_name,
              i.price, i.qty
            FROM products p
            LEFT JOIN brands b ON b.id = p.brand_id
            INNER JOIN inventory i ON i.product_id = p.id
            WHERE p.id IN ($placeholders) AND p.is_active = 1
        ";

        $stmt = $pdo->prepare($sql);
        foreach ($ids as $i => $id) {
            $stmt->bindValue($i + 1, (int)$id, \PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $slug = trim($slug);
        if ($slug === '') return null;

        $pdo = \App\Helpers\DB::pdo();
        $stmt = $pdo->prepare("
            SELECT 
              p.id, p.name, p.slug, p.description, p.rating,
              c.id AS category_id, c.name AS category_name,
              b.id AS brand_id, b.name AS brand_name,
              i.price, i.qty
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            LEFT JOIN brands b ON b.id = p.brand_id
            INNER JOIN inventory i ON i.product_id = p.id
            WHERE p.slug = :slug AND p.is_active = 1
            LIMIT 1
        ");
        $stmt->execute([':slug' => $slug]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function images(int $productId): array
    {
        $pdo = \App\Helpers\DB::pdo();
        $stmt = $pdo->prepare("
            SELECT id, file_name, sort_order, is_main
            FROM product_images
            WHERE product_id = :pid
            ORDER BY is_main DESC, sort_order ASC, id ASC
        ");
        $stmt->execute([':pid' => $productId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function related(int $categoryId, int $excludeProductId, int $limit = 8): array
    {
        $limit = max(1, min(24, $limit));
        $pdo = \App\Helpers\DB::pdo();

        // limit رقم ثابت لتجنب مشاكل bind في بعض PDO
        $sql = "
            SELECT 
              p.id, p.name, p.slug, p.rating,
              b.name AS brand_name,
              i.price, i.qty
            FROM products p
            LEFT JOIN brands b ON b.id = p.brand_id
            INNER JOIN inventory i ON i.product_id = p.id
            WHERE p.is_active = 1
              AND p.category_id = :cid
              AND p.id <> :exclude
            ORDER BY p.id DESC
            LIMIT {$limit}
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':cid' => $categoryId, ':exclude' => $excludeProductId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function browse(array $params): array
    {
        $pdo = \App\Helpers\DB::pdo();

        $q = trim((string)($params['q'] ?? ''));
        $categoryId = (int)($params['category_id'] ?? 0);
        $brandId = (int)($params['brand_id'] ?? 0);

        $sort = (string)($params['sort'] ?? 'new'); // new, price_asc, price_desc, rating
        $page = max(1, (int)($params['page'] ?? 1));
        $perPage = max(4, min(24, (int)($params['per_page'] ?? 12)));
        $offset = ($page - 1) * $perPage;

        $where = ["p.is_active = 1"];
        $bind = [];

        if ($q !== '') {
            $where[] = "(p.name LIKE :q OR b.name LIKE :q2 OR c.name LIKE :q3)";
            $like = '%' . $q . '%';
            $bind[':q'] = $like;
            $bind[':q2'] = $like;
            $bind[':q3'] = $like;
        }
        if ($categoryId > 0) {
            $where[] = "p.category_id = :cid";
            $bind[':cid'] = $categoryId;
        }
        if ($brandId > 0) {
            $where[] = "p.brand_id = :bid";
            $bind[':bid'] = $brandId;
        }

        $whereSql = 'WHERE ' . implode(' AND ', $where);

        $orderSql = "ORDER BY p.id DESC";
        if ($sort === 'price_asc')  $orderSql = "ORDER BY i.price ASC, p.id DESC";
        if ($sort === 'price_desc') $orderSql = "ORDER BY i.price DESC, p.id DESC";
        if ($sort === 'rating')     $orderSql = "ORDER BY p.rating DESC, p.id DESC";

        // Count
        $stmtCount = $pdo->prepare("
            SELECT COUNT(*) AS cnt
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            LEFT JOIN brands b ON b.id = p.brand_id
            INNER JOIN inventory i ON i.product_id = p.id
            $whereSql
        ");
        $stmtCount->execute($bind);
        $total = (int)($stmtCount->fetch(\PDO::FETCH_ASSOC)['cnt'] ?? 0);

        // Data (limit/offset أرقام ثابتة)
        $sql = "
            SELECT 
              p.id, p.name, p.slug, p.rating,
              c.name AS category_name,
              b.name AS brand_name,
              i.price, i.qty,
              (
                SELECT pi.file_name
                FROM product_images pi
                WHERE pi.product_id = p.id
                ORDER BY pi.is_main DESC, pi.sort_order ASC, pi.id ASC
                LIMIT 1
              ) AS main_image
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            LEFT JOIN brands b ON b.id = p.brand_id
            INNER JOIN inventory i ON i.product_id = p.id
            $whereSql
            $orderSql
            LIMIT $perPage OFFSET $offset
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bind);
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'pages' => (int)ceil($total / $perPage),
        ];
    }

    public static function bestSellers(int $days = 30, int $limit = 8): array
    {
        $days = max(1, min(365, $days));
        $limit = max(1, min(24, $limit));

        $pdo = \App\Helpers\DB::pdo();

        // ✅ نحسب الأكثر مبيعاً من الطلبات التي ليست pending (حسب طلبك)
        $sql = "
          SELECT
            p.id, p.name, p.slug, p.rating,
            b.name AS brand_name,
            c.name AS category_name,
            i.price, i.qty,
            SUM(oi.qty) AS sold_qty,
            (
              SELECT pi.file_name
              FROM product_images pi
              WHERE pi.product_id = p.id
              ORDER BY pi.is_main DESC, pi.sort_order ASC, pi.id ASC
              LIMIT 1
            ) AS main_image
          FROM order_items oi
          INNER JOIN orders o ON o.id = oi.order_id
          INNER JOIN products p ON p.id = oi.product_id
          LEFT JOIN brands b ON b.id = p.brand_id
          LEFT JOIN categories c ON c.id = p.category_id
          INNER JOIN inventory i ON i.product_id = p.id
          WHERE o.status <> 'pending'
            AND o.created_at >= (NOW() - INTERVAL {$days} DAY)
            AND p.is_active = 1
          GROUP BY p.id
          ORDER BY sold_qty DESC, p.id DESC
          LIMIT {$limit}
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function imagesByProductId(int $productId): array
    {
        $pdo = \App\Helpers\DB::pdo();
        $stmt = $pdo->prepare("
            SELECT id, file_name, is_main, sort_order
            FROM product_images
            WHERE product_id = :pid
            ORDER BY is_main DESC, sort_order ASC, id ASC
        ");
        $stmt->execute([':pid' => $productId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}