<?php

namespace App\Admin\Models;

use PDO;
use Throwable;

class Product
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

public function getAll(?string $search = null, ?string $status = null, int $limit = 10, int $offset = 0): array
{
    $sql = "
        SELECT
            p.id,
            p.name,
            p.slug,
            p.description,
            p.rating,
            p.is_active,
            p.created_at,

            b.name AS brand_name,
            c.name AS category_name,

            i.price,
            i.cost_price,
            i.qty,

            pi.file_name AS main_image
        FROM products p
        LEFT JOIN brands b
            ON b.id = p.brand_id
        LEFT JOIN categories c
            ON c.id = p.category_id
        LEFT JOIN inventory i
            ON i.product_id = p.id
        LEFT JOIN product_images pi
            ON pi.product_id = p.id
           AND pi.is_main = 1
        WHERE 1=1
    ";

    $params = [];

    if ($search !== null && trim($search) !== '') {
        $sql .= " AND (
            p.name LIKE :search
            OR p.slug LIKE :search
            OR b.name LIKE :search
            OR c.name LIKE :search
        )";
        $params[':search'] = '%' . trim($search) . '%';
    }

    if ($status !== null && $status !== '' && $status !== 'all') {
    $sql .= " AND p.is_active = :is_active";
    $params[':is_active'] = $status === 'active' ? 1 : 0;
    }

    $sql .= " ORDER BY p.id DESC";
    $sql .= " LIMIT :limit OFFSET :offset";
    
    $stmt = $this->db->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

}

public function findById(int $id): array|false
{
    $sql = "
        SELECT
            p.id,
            p.name,
            p.slug,
            p.description,
            p.rating,
            p.is_active,
            p.brand_id,
            p.category_id,

            i.price,
            i.cost_price,
            i.qty,

            pi.file_name AS main_image,

            (
                SELECT GROUP_CONCAT(pg.file_name ORDER BY pg.sort_order ASC SEPARATOR '||')
                FROM product_images pg
                WHERE pg.product_id = p.id
                  AND pg.is_main = 0
            ) AS gallery_images_list
        FROM products p
        LEFT JOIN inventory i
            ON i.product_id = p.id
        LEFT JOIN product_images pi
            ON pi.product_id = p.id
           AND pi.is_main = 1
        WHERE p.id = :id
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':id' => $id,
    ]);

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        return false;
    }

    $galleryList = trim((string)($product['gallery_images_list'] ?? ''));
    $product['gallery_images'] = $galleryList !== ''
        ? explode('||', $galleryList)
        : [];

    return $product;
}

public function create(array $data): bool
{
    $name = trim((string)($data['name'] ?? ''));
    $slug = trim((string)($data['slug'] ?? ''));
    $description = trim((string)($data['description'] ?? ''));
    $brandId = (int)($data['brand_id'] ?? 0);
    $categoryId = (int)($data['category_id'] ?? 0);
    $price = (float)($data['price'] ?? 0);
    $costPrice = (float)($data['cost_price'] ?? 0);
    $qty = (int)($data['qty'] ?? 0);
    $rating = (float)($data['rating'] ?? 0);
    $isActive = (int)($data['is_active'] ?? 1);
    $mainImage = trim((string)($data['main_image'] ?? ''));
    $galleryImages = is_array($data['gallery_images'] ?? null) ? $data['gallery_images'] : [];

    if ($name === '' || $slug === '' || $brandId <= 0 || $categoryId <= 0) {
        return false;
    }

    try {
        $this->db->beginTransaction();

        $sqlProduct = "
            INSERT INTO products (
                brand_id,
                category_id,
                name,
                slug,
                description,
                rating,
                is_active
            ) VALUES (
                :brand_id,
                :category_id,
                :name,
                :slug,
                :description,
                :rating,
                :is_active
            )
        ";

        $stmtProduct = $this->db->prepare($sqlProduct);
        $stmtProduct->execute([
            ':brand_id' => $brandId,
            ':category_id' => $categoryId,
            ':name' => $name,
            ':slug' => $slug,
            ':description' => $description,
            ':rating' => $rating,
            ':is_active' => $isActive,
        ]);

        $productId = (int)$this->db->lastInsertId();

        $sqlInventory = "
            INSERT INTO inventory (
                product_id,
                price,
                cost_price,
                qty
            ) VALUES (
                :product_id,
                :price,
                :cost_price,
                :qty
            )
            ON DUPLICATE KEY UPDATE
                price = VALUES(price),
                cost_price = VALUES(cost_price),
                qty = VALUES(qty)
        ";

        $stmtInventory = $this->db->prepare($sqlInventory);
        $stmtInventory->execute([
            ':product_id' => $productId,
            ':price' => $price,
            ':cost_price' => $costPrice,
            ':qty' => $qty,
        ]);

        if ($mainImage !== '') {
            $sqlImage = "
                INSERT INTO product_images (
                    product_id,
                    file_name,
                    is_main,
                    sort_order
                ) VALUES (
                    :product_id,
                    :file_name,
                    1,
                    0
                )
            ";

            $stmtImage = $this->db->prepare($sqlImage);
            $stmtImage->execute([
                ':product_id' => $productId,
                ':file_name' => $mainImage,
            ]);
        }

        if (!empty($galleryImages)) {
            $sqlGallery = "
                INSERT INTO product_images (
                    product_id,
                    file_name,
                    is_main,
                    sort_order
                ) VALUES (
                    :product_id,
                    :file_name,
                    0,
                    :sort_order
                )
            ";

            $stmtGallery = $this->db->prepare($sqlGallery);

            foreach ($galleryImages as $index => $fileName) {
                $fileName = trim((string)$fileName);
                if ($fileName === '') {
                    continue;
                }

                $stmtGallery->execute([
                    ':product_id' => $productId,
                    ':file_name' => $fileName,
                    ':sort_order' => $index + 1,
                ]);
            }
        }

        $this->db->commit();
        return true;
    } catch (Throwable $e) {
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }

        throw $e;
    }
}

public function update(int $id, array $data): bool
{
    $name = trim((string)($data['name'] ?? ''));
    $slug = trim((string)($data['slug'] ?? ''));
    $description = trim((string)($data['description'] ?? ''));
    $brandId = (int)($data['brand_id'] ?? 0);
    $categoryId = (int)($data['category_id'] ?? 0);
    $price = (float)($data['price'] ?? 0);
    $costPrice = (float)($data['cost_price'] ?? 0);
    $qty = (int)($data['qty'] ?? 0);
    $rating = (float)($data['rating'] ?? 0);
    $isActive = (int)($data['is_active'] ?? 1);
    $mainImage = trim((string)($data['main_image'] ?? ''));
    $galleryImages = is_array($data['gallery_images'] ?? null) ? $data['gallery_images'] : [];

    if ($id <= 0 || $name === '' || $slug === '' || $brandId <= 0 || $categoryId <= 0) {
        return false;
    }

    try {
        $this->db->beginTransaction();

        $sqlProduct = "
            UPDATE products
            SET
                brand_id = :brand_id,
                category_id = :category_id,
                name = :name,
                slug = :slug,
                description = :description,
                rating = :rating,
                is_active = :is_active
            WHERE id = :id
            LIMIT 1
        ";

        $stmtProduct = $this->db->prepare($sqlProduct);
        $stmtProduct->execute([
            ':brand_id' => $brandId,
            ':category_id' => $categoryId,
            ':name' => $name,
            ':slug' => $slug,
            ':description' => $description,
            ':rating' => $rating,
            ':is_active' => $isActive,
            ':id' => $id,
        ]);

        $sqlInventory = "
            UPDATE inventory
            SET
                price = :price,
                cost_price = :cost_price,
                qty = :qty
            WHERE product_id = :product_id
            LIMIT 1
        ";

        $stmtInventory = $this->db->prepare($sqlInventory);
        $stmtInventory->execute([
            ':price' => $price,
            ':cost_price' => $costPrice,
            ':qty' => $qty,
            ':product_id' => $id,
        ]);

        if ($mainImage !== '') {
            $sqlDeleteMain = "
                DELETE FROM product_images
                WHERE product_id = :product_id
                  AND is_main = 1
            ";

            $stmtDeleteMain = $this->db->prepare($sqlDeleteMain);
            $stmtDeleteMain->execute([
                ':product_id' => $id,
            ]);

            $sqlImage = "
                INSERT INTO product_images (
                    product_id,
                    file_name,
                    is_main,
                    sort_order
                ) VALUES (
                    :product_id,
                    :file_name,
                    1,
                    0
                )
            ";

            $stmtImage = $this->db->prepare($sqlImage);
            $stmtImage->execute([
                ':product_id' => $id,
                ':file_name' => $mainImage,
            ]);
        }

        if (!empty($galleryImages)) {
            $sqlDeleteGallery = "
                DELETE FROM product_images
                WHERE product_id = :product_id
                  AND is_main = 0
            ";

            $stmtDeleteGallery = $this->db->prepare($sqlDeleteGallery);
            $stmtDeleteGallery->execute([
                ':product_id' => $id,
            ]);

            $sqlGallery = "
                INSERT INTO product_images (
                    product_id,
                    file_name,
                    is_main,
                    sort_order
                ) VALUES (
                    :product_id,
                    :file_name,
                    0,
                    :sort_order
                )
            ";

            $stmtGallery = $this->db->prepare($sqlGallery);

            foreach ($galleryImages as $index => $fileName) {
                $fileName = trim((string)$fileName);
                if ($fileName === '') {
                    continue;
                }

                $stmtGallery->execute([
                    ':product_id' => $id,
                    ':file_name' => $fileName,
                    ':sort_order' => $index + 1,
                ]);
            }
        }

        $this->db->commit();
        return true;
    } catch (Throwable $e) {
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }

        throw $e;
    }
}

    public function delete(int $id): bool
    {
        if ($id <= 0) {
            return false;
        }

        try {
            $this->db->beginTransaction();

            $stmt1 = $this->db->prepare("DELETE FROM product_images WHERE product_id = :id");
            $stmt1->execute([':id' => $id]);

            $stmt2 = $this->db->prepare("DELETE FROM inventory WHERE product_id = :id");
            $stmt2->execute([':id' => $id]);

            $stmt3 = $this->db->prepare("DELETE FROM products WHERE id = :id LIMIT 1");
            $stmt3->execute([':id' => $id]);

            $this->db->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $e;
        }
    }


    public function countAll(?string $search = null, ?string $status = null): int
{
    $sql = "
        SELECT COUNT(*)
        FROM products p
        LEFT JOIN brands b
            ON b.id = p.brand_id
        LEFT JOIN categories c
            ON c.id = p.category_id
        WHERE 1=1
    ";

    $params = [];

    if ($search !== null && trim($search) !== '') {
        $sql .= " AND (
            p.name LIKE :search
            OR p.slug LIKE :search
            OR b.name LIKE :search
            OR c.name LIKE :search
        )";
        $params[':search'] = '%' . trim($search) . '%';
    }

    if ($status !== null && $status !== '' && $status !== 'all') {
        $sql .= " AND p.is_active = :is_active";
        $params[':is_active'] = $status === 'active' ? 1 : 0;
    }

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return (int)$stmt->fetchColumn();
}

}