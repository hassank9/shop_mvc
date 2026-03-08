<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Order;
use PDO;
use PDOException;

class OrdersApiController
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

    public function show(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['admin_id'])) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'رقم الطلب غير صالح',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $orderModel = new Order($this->db);

        $order = $orderModel->findById($id);
        if (!$order) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'الطلب غير موجود',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $items = $orderModel->getItemsByOrderId($id);

        echo json_encode([
            'success' => true,
            'order' => $order,
            'items' => $items,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function updateStatus(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    header('Content-Type: application/json; charset=utf-8');

    if (!isset($_SESSION['admin_id'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Unauthorized',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $id = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? '');

    if ($id <= 0 || $status === '') {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'البيانات المرسلة غير صالحة',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $orderModel = new Order($this->db);

    $order = $orderModel->findById($id);
    if (!$order) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'الطلب غير موجود',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $updated = $orderModel->updateStatus($id, $status);

    if (!$updated) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'تعذر تحديث الحالة',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'تم تحديث حالة الطلب بنجاح',
        'status' => $status,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

}