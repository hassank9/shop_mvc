<?php

namespace App\Admin\Controllers;

use App\Admin\Models\UserManager;
use PDO;
use PDOException;

class UsersApiController
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

        $type = trim($_POST['type'] ?? '');
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0 || ($type !== 'user' && $type !== 'admin')) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'البيانات المرسلة غير صالحة',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $userManager = new UserManager($this->db);

        if ($type === 'user') {
            $fullName = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');

            $updated = $userManager->updateUser($id, $fullName, $phone, $address);

            if (!$updated) {
                http_response_code(422);
                echo json_encode([
                    'success' => false,
                    'message' => 'تعذر تحديث بيانات المستخدم',
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            echo json_encode([
                'success' => true,
                'message' => 'تم تحديث بيانات المستخدم بنجاح',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $fullName = trim($_POST['full_name'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $role = trim($_POST['role'] ?? '');

        $updated = $userManager->updateAdmin($id, $fullName, $username, $role);

        if (!$updated) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'تعذر تحديث بيانات الأدمن',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => 'تم تحديث بيانات الأدمن بنجاح',
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

    $type = trim($_POST['type'] ?? '');
    $id = (int)($_POST['id'] ?? 0);

    if ($id <= 0 || ($type !== 'user' && $type !== 'admin')) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'البيانات المرسلة غير صالحة',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $userManager = new UserManager($this->db);

    if ($type === 'user') {
        $deleted = $userManager->deleteUser($id);

        if (!$deleted) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'تعذر حذف المستخدم',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => 'تم حذف المستخدم بنجاح',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $deleted = $userManager->deleteAdmin($id);

    if (!$deleted) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'تعذر حذف الأدمن',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'تم حذف الأدمن بنجاح',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

}