<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Brand;
use PDO;
use PDOException;

class BrandsApiController
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
            http_response_code(500);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => false,
                'message' => 'Database connection failed',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    public function store(): void
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

        $name = trim($_POST['name'] ?? '');

        if ($name === '') {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'يرجى إدخال اسم البراند',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $brandModel = new Brand($this->db);
        $created = $brandModel->create($name);

        if (!$created) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'تعذر حفظ البراند',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => 'تم إضافة البراند بنجاح',
        ], JSON_UNESCAPED_UNICODE);
        exit;
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
                'message' => 'رقم البراند غير صالح',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $brandModel = new Brand($this->db);
        $brand = $brandModel->findById($id);

        if (!$brand) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'البراند غير موجود',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'brand' => $brand,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function update(): void
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
        $name = trim($_POST['name'] ?? '');

        if ($id <= 0 || $name === '') {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'البيانات المرسلة غير صالحة',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $brandModel = new Brand($this->db);
        $brand = $brandModel->findById($id);

        if (!$brand) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'البراند غير موجود',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $updated = $brandModel->update($id, $name);

        if (!$updated) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'تعذر تحديث البراند',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => 'تم تعديل البراند بنجاح',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function delete(): void
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

        if ($id <= 0) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'رقم البراند غير صالح',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $brandModel = new Brand($this->db);
        $brand = $brandModel->findById($id);

        if (!$brand) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'البراند غير موجود',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $deleted = $brandModel->delete($id);

        if (!$deleted) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'تعذر حذف البراند',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => 'تم حذف البراند بنجاح',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}