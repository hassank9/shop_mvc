<?php

namespace App\Admin\Controllers;

use App\Admin\Helpers\AdminUrl;
use App\Admin\Models\Order;
use PDO;
use PDOException;

class OrdersController
{
    protected ?PDO $db = null;

    public function __construct()
    {
        $this->db = $this->createAdminConnection();
    }

    private function createAdminConnection(): PDO
    {
        $host = 'localhost';
        $dbname = 'firstclass_shop';
        $username = 'root';
        $password = '';

        try {
            return new PDO(
                "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                $username,
                $password,
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

        $orderModel = new Order($this->db);

        $status = trim($_GET['status'] ?? 'all');
        $dateFrom = trim($_GET['date_from'] ?? '');
        $dateTo = trim($_GET['date_to'] ?? '');

        $orders = $orderModel->getAll($status, $dateFrom, $dateTo);

        $currentStatus = $status;
        $currentDateFrom = $dateFrom;
        $currentDateTo = $dateTo;

        $pageTitle = 'الطلبات';
        $contentView = dirname(__DIR__) . '/Views/orders/index.php';

        require dirname(__DIR__) . '/Views/layouts/admin.php';
    }

    public function show(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin_id'])) {
            header('Location: ' . AdminUrl::path('/admin/login'));
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            die('رقم الطلب غير صالح');
        }

        $orderModel = new Order($this->db);

        $order = $orderModel->findById($id);
        if (!$order) {
            die('الطلب غير موجود');
        }

        $items = $orderModel->getItemsByOrderId($id);

        $pageTitle = 'تفاصيل الطلب #' . $id;
        $contentView = dirname(__DIR__) . '/Views/orders/show.php';

        require dirname(__DIR__) . '/Views/layouts/admin.php';
    }
}