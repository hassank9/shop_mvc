<?php

namespace App\Admin\Models;

use PDO;

class DashboardStats
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getUsersCount(): int
    {
        $sql = "SELECT COUNT(*) FROM users";
        return (int) $this->db->query($sql)->fetchColumn();
    }

    public function getOrdersCount(): int
    {
        $sql = "SELECT COUNT(*) FROM orders";
        return (int) $this->db->query($sql)->fetchColumn();
    }

    public function getPendingOrdersCount(): int
    {
        $sql = "SELECT COUNT(*) FROM orders WHERE status = :status";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':status' => 'pending']);
        return (int) $stmt->fetchColumn();
    }

    public function getDeliveredOrdersCount(): int
    {
        $sql = "SELECT COUNT(*) FROM orders WHERE status = :status";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':status' => 'delivered']);
        return (int) $stmt->fetchColumn();
    }

    public function getApprovedOrdersCount(): int
{
    $sql = "SELECT COUNT(*) FROM orders WHERE status = :status";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':status' => 'approved']);
    return (int) $stmt->fetchColumn();
}

public function getOutForDeliveryOrdersCount(): int
{
    $sql = "SELECT COUNT(*) FROM orders WHERE status = :status";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':status' => 'out_for_delivery']);
    return (int) $stmt->fetchColumn();
}

public function getCancelledOrdersCount(): int
{
    $sql = "SELECT COUNT(*) FROM orders WHERE status = :status";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':status' => 'cancelled']);
    return (int) $stmt->fetchColumn();
}

public function getTotalSales(): float
{
    $sql = "SELECT COALESCE(SUM(total), 0) FROM orders";
    return (float) $this->db->query($sql)->fetchColumn();
}

public function getTotalProfit(): float
{
    $sql = "
        SELECT COALESCE(SUM((oi.unit_price - oi.cost_price) * oi.qty), 0)
        FROM order_items oi
        INNER JOIN orders o ON o.id = oi.order_id
        WHERE o.status <> :cancelled
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':cancelled' => 'cancelled'
    ]);

    return (float) $stmt->fetchColumn();
}

public function getLowStockProducts(int $limit = 5, ?int $threshold = null): array
{
    if ($threshold === null) {
    $threshold = (int)$this->getSetting('low_stock_threshold', '3');
    }
    
    $sql = "
        SELECT
            p.name AS product_name,
            b.name AS brand_name,
            i.qty,
            i.product_id
        FROM inventory i
        INNER JOIN products p ON p.id = i.product_id
        LEFT JOIN brands b ON b.id = p.brand_id
        WHERE i.qty <= :threshold
        ORDER BY i.qty ASC, p.name ASC
        LIMIT :limit
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':threshold', $threshold, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

public function getSetting(string $key, string $default = ''): string
{
    $allowedColumns = [
        'low_stock_threshold',
        'site_name_ar',
        'site_name_en',
        'site_description',
        'logo',
        'favicon',
        'about_title',
        'about_text',
        'about_image',
        'contact_phone_1',
        'contact_phone_2',
        'contact_whatsapp',
        'contact_email',
        'contact_address',
        'contact_map_url',
        'facebook_url',
        'instagram_url',
        'telegram_url',
        'tiktok_url',
        'receipt_store_name',
        'receipt_header_text',
        'receipt_footer_text',
        'receipt_show_logo',
        'receipt_show_address',
        'receipt_show_contacts',
        'receipt_barcode_type',
        'receipt_barcode_value'
    ];

    if (!in_array($key, $allowedColumns, true)) {
        return $default;
    }

    $sql = "SELECT `$key` FROM settings ORDER BY id ASC LIMIT 1";
    $stmt = $this->db->query($sql);

    $value = $stmt->fetchColumn();

    return $value !== false && $value !== null ? (string) $value : $default;
}

}