<?php

namespace App\Admin\Controllers;

use App\Admin\Helpers\AdminUrl;
use App\Admin\Models\DashboardStats;
use PDO;
use PDOException;

class DashboardController
{
    protected ?PDO $db = null;

    public function __construct()
    {
        $this->db = $this->createAdminConnection();
    }

private function createAdminConnection(): PDO
{
    $config = require dirname(__DIR__, 3) . '/config/database.php';

    try {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";

        return new PDO(
            $dsn,
            $config['username'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    } catch (PDOException $e) {
        die('Admin DB Connection Failed: ' . $e->getMessage());
    }
}

    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin_id'])) {
            header('Location: ' . AdminUrl::path('/admin/login'));
            exit;
        }

        $statsModel = new DashboardStats($this->db);

        $stats = [
        'users_count' => $statsModel->getUsersCount(),
        'orders_count' => $statsModel->getOrdersCount(),
        'pending_orders_count' => $statsModel->getPendingOrdersCount(),
        'delivered_orders_count' => $statsModel->getDeliveredOrdersCount(),
        'approved_orders_count' => $statsModel->getApprovedOrdersCount(),
        'out_for_delivery_orders_count' => $statsModel->getOutForDeliveryOrdersCount(),
        'cancelled_orders_count' => $statsModel->getCancelledOrdersCount(),
        'total_sales' => $statsModel->getTotalSales(),
        'total_profit' => $statsModel->getTotalProfit(),
        'low_stock_products' => $statsModel->getLowStockProducts(),
        'low_stock_threshold' => (int) $statsModel->getSetting('low_stock_threshold', '3'),
         ];

        $pageTitle = 'الرئيسية';
        $contentView = dirname(__DIR__) . '/Views/dashboard/content.php';

        require dirname(__DIR__) . '/Views/layouts/admin.php';
    }
}