<?php

namespace App\Admin\Models;

use PDO;

class Order
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

public function getAll(?string $status = null, ?string $dateFrom = null, ?string $dateTo = null): array
{
    $sql = "
        SELECT
            id,
            user_id,
            customer_name,
            customer_phone,
            total,
            status,
            notes,
            created_at
        FROM orders
        WHERE 1=1
    ";

    $params = [];

    if ($status !== null && $status !== '' && $status !== 'all') {
        $sql .= " AND status = :status";
        $params[':status'] = $status;
    }

    if ($dateFrom !== null && $dateFrom !== '') {
        $sql .= " AND DATE(created_at) >= :date_from";
        $params[':date_from'] = $dateFrom;
    }

    if ($dateTo !== null && $dateTo !== '') {
        $sql .= " AND DATE(created_at) <= :date_to";
        $params[':date_to'] = $dateTo;
    }

    $sql .= " ORDER BY id DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

public function findById(int $id): array|false
{
    $sql = "
        SELECT
            o.id,
            o.user_id,
            o.customer_name,
            o.customer_phone,
            u.address,
            o.total,
            o.status,
            o.notes,
            o.created_at
        FROM orders o
        LEFT JOIN users u ON u.id = o.user_id
        WHERE o.id = :id
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getItemsByOrderId(int $orderId): array
{
    $sql = "
        SELECT
            oi.id,
            oi.product_id,
            oi.qty,
            oi.unit_price,
            oi.cost_price,
            p.name AS product_name
        FROM order_items oi
        INNER JOIN products p ON p.id = oi.product_id
        WHERE oi.order_id = :order_id
        ORDER BY oi.id ASC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([':order_id' => $orderId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}


public function updateStatus(int $id, string $status): bool
{
    $allowedStatuses = [
        'pending',
        'approved',
        'out_for_delivery',
        'delivered',
        'cancelled',
    ];

    if (!in_array($status, $allowedStatuses, true)) {
        return false;
    }

    $sql = "UPDATE orders SET status = :status WHERE id = :id LIMIT 1";
    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':status' => $status,
        ':id' => $id,
    ]);
}


}