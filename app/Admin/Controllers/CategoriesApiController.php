<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Category;
use PDO;
use PDOException;

class CategoriesApiController
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
                'message' => 'يرجى إدخال اسم الصنف',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $categoryModel = new Category($this->db);
        $created = $categoryModel->create($name);

        if (!$created) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'تعذر حفظ الصنف',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => 'تم إضافة الصنف بنجاح',
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
                'message' => 'رقم الصنف غير صالح',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $categoryModel = new Category($this->db);
        $category = $categoryModel->findById($id);

        if (!$category) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'الصنف غير موجود',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'category' => $category,
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

        $categoryModel = new Category($this->db);
        $category = $categoryModel->findById($id);

        if (!$category) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'الصنف غير موجود',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $updated = $categoryModel->update($id, $name);

        if (!$updated) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'تعذر تحديث الصنف',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => 'تم تعديل الصنف بنجاح',
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
                'message' => 'رقم الصنف غير صالح',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $categoryModel = new Category($this->db);
        $category = $categoryModel->findById($id);

        if (!$category) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'الصنف غير موجود',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $deleted = $categoryModel->delete($id);

        if (!$deleted) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'تعذر حذف الصنف',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => 'تم حذف الصنف بنجاح',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}