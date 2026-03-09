<?php

namespace App\Admin\Controllers;

use PDO;
use PDOException;

class HeroApiController
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

    private function jsonResponse(bool $success, string $message, array $extra = [], int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(array_merge([
            'success' => $success,
            'message' => $message,
        ], $extra), JSON_UNESCAPED_UNICODE);

        exit;
    }

    private function ensureAuthenticated(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin_id'])) {
            $this->jsonResponse(false, 'Unauthorized', [], 401);
        }
    }

    private function getUploadDirectory(): string
    {
        return dirname(__DIR__, 3) . '/public/uploads/hero';
    }

    private function ensureUploadDirectoryExists(string $dir): bool
    {
        if (is_dir($dir)) {
            return true;
        }

        return mkdir($dir, 0777, true);
    }

    private function getSlideById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM hero_slides WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $slide = $stmt->fetch(PDO::FETCH_ASSOC);

        return $slide ?: null;
    }

    private function uploadImage(string $fieldName, string $prefix, ?string $oldFile = null): ?string
    {
        if (
            !isset($_FILES[$fieldName]) ||
            !is_array($_FILES[$fieldName]) ||
            (int)($_FILES[$fieldName]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE
        ) {
            return $oldFile;
        }

        $file = $_FILES[$fieldName];

        if ((int)$file['error'] !== UPLOAD_ERR_OK) {
            return $oldFile;
        }

        $tmpPath = (string)$file['tmp_name'];
        $originalName = (string)$file['name'];

        if (!is_uploaded_file($tmpPath)) {
            return $oldFile;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions, true)) {
            return $oldFile;
        }

        $uploadDir = $this->getUploadDirectory();

        if (!$this->ensureUploadDirectoryExists($uploadDir)) {
            return $oldFile;
        }

        $fileName = $prefix . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
        $destination = $uploadDir . '/' . $fileName;

        if (!move_uploaded_file($tmpPath, $destination)) {
            return $oldFile;
        }

        if (!empty($oldFile)) {
            $oldBaseName = basename($oldFile);
            $oldPath = $uploadDir . '/' . $oldBaseName;

            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        return '/uploads/hero/' . $fileName;
    }

    public function store(): void
    {
        $this->ensureAuthenticated();

        $title = trim($_POST['title'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $buttonText1 = trim($_POST['button_text_1'] ?? '');
        $buttonLink1 = trim($_POST['button_link_1'] ?? '');
        $buttonText2 = trim($_POST['button_text_2'] ?? '');
        $buttonLink2 = trim($_POST['button_link_2'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        $image = $this->uploadImage('image', 'hero', null);

        $stmt = $this->db->prepare("
            INSERT INTO hero_slides
            (title, subtitle, button_text_1, button_link_1, button_text_2, button_link_2, image, sort_order, is_active)
            VALUES
            (:title, :subtitle, :button_text_1, :button_link_1, :button_text_2, :button_link_2, :image, :sort_order, :is_active)
        ");

        $ok = $stmt->execute([
            ':title' => $title,
            ':subtitle' => $subtitle,
            ':button_text_1' => $buttonText1,
            ':button_link_1' => $buttonLink1,
            ':button_text_2' => $buttonText2,
            ':button_link_2' => $buttonLink2,
            ':image' => $image,
            ':sort_order' => $sortOrder,
            ':is_active' => $isActive,
        ]);

        if (!$ok) {
            $this->jsonResponse(false, 'تعذر إضافة السلايد', [], 422);
        }

        $this->jsonResponse(true, 'تمت إضافة السلايد بنجاح');
    }

    public function update(): void
    {
        $this->ensureAuthenticated();

        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            $this->jsonResponse(false, 'معرف السلايد غير صالح', [], 422);
        }

        $slide = $this->getSlideById($id);

        if (!$slide) {
            $this->jsonResponse(false, 'السلايد غير موجود', [], 404);
        }

        $title = trim($_POST['title'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $buttonText1 = trim($_POST['button_text_1'] ?? '');
        $buttonLink1 = trim($_POST['button_link_1'] ?? '');
        $buttonText2 = trim($_POST['button_text_2'] ?? '');
        $buttonLink2 = trim($_POST['button_link_2'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        $image = $this->uploadImage('image', 'hero', $slide['image'] ?? null);

        $stmt = $this->db->prepare("
            UPDATE hero_slides SET
                title = :title,
                subtitle = :subtitle,
                button_text_1 = :button_text_1,
                button_link_1 = :button_link_1,
                button_text_2 = :button_text_2,
                button_link_2 = :button_link_2,
                image = :image,
                sort_order = :sort_order,
                is_active = :is_active
            WHERE id = :id
            LIMIT 1
        ");

        $ok = $stmt->execute([
            ':title' => $title,
            ':subtitle' => $subtitle,
            ':button_text_1' => $buttonText1,
            ':button_link_1' => $buttonLink1,
            ':button_text_2' => $buttonText2,
            ':button_link_2' => $buttonLink2,
            ':image' => $image,
            ':sort_order' => $sortOrder,
            ':is_active' => $isActive,
            ':id' => $id,
        ]);

        if (!$ok) {
            $this->jsonResponse(false, 'تعذر تحديث السلايد', [], 422);
        }

        $this->jsonResponse(true, 'تم تحديث السلايد بنجاح');
    }

    public function delete(): void
    {
        $this->ensureAuthenticated();

        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            $this->jsonResponse(false, 'معرف السلايد غير صالح', [], 422);
        }

        $slide = $this->getSlideById($id);

        if (!$slide) {
            $this->jsonResponse(false, 'السلايد غير موجود', [], 404);
        }

        $stmt = $this->db->prepare("DELETE FROM hero_slides WHERE id = :id LIMIT 1");
        $ok = $stmt->execute([':id' => $id]);

        if (!$ok) {
            $this->jsonResponse(false, 'تعذر حذف السلايد', [], 422);
        }

        if (!empty($slide['image'])) {
            $uploadDir = $this->getUploadDirectory();
            $imagePath = $uploadDir . '/' . basename($slide['image']);

            if (is_file($imagePath)) {
                @unlink($imagePath);
            }
        }

        $this->jsonResponse(true, 'تم حذف السلايد بنجاح');
    }

    public function toggle(): void
    {
        $this->ensureAuthenticated();

        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            $this->jsonResponse(false, 'معرف السلايد غير صالح', [], 422);
        }

        $slide = $this->getSlideById($id);

        if (!$slide) {
            $this->jsonResponse(false, 'السلايد غير موجود', [], 404);
        }

        $newStatus = !empty($slide['is_active']) ? 0 : 1;

        $stmt = $this->db->prepare("
            UPDATE hero_slides
            SET is_active = :is_active
            WHERE id = :id
            LIMIT 1
        ");

        $ok = $stmt->execute([
            ':is_active' => $newStatus,
            ':id' => $id,
        ]);

        if (!$ok) {
            $this->jsonResponse(false, 'تعذر تغيير حالة السلايد', [], 422);
        }

        $this->jsonResponse(true, 'تم تحديث حالة السلايد بنجاح', [
            'is_active' => $newStatus,
        ]);
    }
}