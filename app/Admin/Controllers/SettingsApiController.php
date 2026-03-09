<?php

namespace App\Admin\Controllers;

use PDO;
use PDOException;

class SettingsApiController
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

    private function getCurrentSettings(int $id): ?array
{
    $stmt = $this->db->prepare("SELECT * FROM settings WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}

private function normalizeUploadDirectory(): string
{
    return dirname(__DIR__, 3) . '/public/uploads/settings';
}

private function ensureUploadDirectoryExists(string $dir): bool
{
    if (is_dir($dir)) {
        return true;
    }

    return mkdir($dir, 0777, true);
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

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'ico'];
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions, true)) {
        return $oldFile;
    }

    $uploadDir = $this->normalizeUploadDirectory();

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

    return '/uploads/settings/' . $fileName;
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

        if ($id <= 0) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'معرف الإعدادات غير صالح',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $site_name_ar          = trim($_POST['site_name_ar'] ?? '');
        $site_name_en          = trim($_POST['site_name_en'] ?? '');
        $site_description      = trim($_POST['site_description'] ?? '');
        $about_title           = trim($_POST['about_title'] ?? '');
        $about_text            = trim($_POST['about_text'] ?? '');
        $contact_phone_1       = trim($_POST['contact_phone_1'] ?? '');
        $contact_phone_2       = trim($_POST['contact_phone_2'] ?? '');
        $contact_whatsapp      = trim($_POST['contact_whatsapp'] ?? '');
        $contact_email         = trim($_POST['contact_email'] ?? '');
        $contact_address       = trim($_POST['contact_address'] ?? '');
        $contact_map_url       = trim($_POST['contact_map_url'] ?? '');
        $facebook_url          = trim($_POST['facebook_url'] ?? '');
        $instagram_url         = trim($_POST['instagram_url'] ?? '');
        $telegram_url          = trim($_POST['telegram_url'] ?? '');
        $tiktok_url            = trim($_POST['tiktok_url'] ?? '');
        $receipt_store_name    = trim($_POST['receipt_store_name'] ?? '');
        $receipt_header_text   = trim($_POST['receipt_header_text'] ?? '');
        $receipt_footer_text   = trim($_POST['receipt_footer_text'] ?? '');
        $receipt_show_logo     = isset($_POST['receipt_show_logo']) ? 1 : 0;
        $receipt_show_address  = isset($_POST['receipt_show_address']) ? 1 : 0;
        $receipt_show_contacts = isset($_POST['receipt_show_contacts']) ? 1 : 0;
        $receipt_barcode_type  = trim($_POST['receipt_barcode_type'] ?? 'qr');
        $receipt_barcode_value = trim($_POST['receipt_barcode_value'] ?? '');
        $low_stock_threshold   = (int)($_POST['low_stock_threshold'] ?? 3);

        if (!in_array($receipt_barcode_type, ['barcode', 'qr'], true)) {
            $receipt_barcode_type = 'qr';
        }

        if ($low_stock_threshold < 0) {
            $low_stock_threshold = 0;
        }

        $currentSettings = $this->getCurrentSettings($id);

        if (!$currentSettings) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'سجل الإعدادات غير موجود',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $logo = $this->uploadImage('logo', 'logo', $currentSettings['logo'] ?? null);
        $favicon = $this->uploadImage('favicon', 'favicon', $currentSettings['favicon'] ?? null);
        $aboutImage = $this->uploadImage('about_image', 'about', $currentSettings['about_image'] ?? null);

$sql = "UPDATE settings SET
            site_name_ar = :site_name_ar,
            site_name_en = :site_name_en,
            site_description = :site_description,
            logo = :logo,
            favicon = :favicon,
            about_title = :about_title,
            about_text = :about_text,
            about_image = :about_image,
            contact_phone_1 = :contact_phone_1,
            contact_phone_2 = :contact_phone_2,
            contact_whatsapp = :contact_whatsapp,
            contact_email = :contact_email,
            contact_address = :contact_address,
            contact_map_url = :contact_map_url,
            facebook_url = :facebook_url,
            instagram_url = :instagram_url,
            telegram_url = :telegram_url,
            tiktok_url = :tiktok_url,
            receipt_store_name = :receipt_store_name,
            receipt_header_text = :receipt_header_text,
            receipt_footer_text = :receipt_footer_text,
            receipt_show_logo = :receipt_show_logo,
            receipt_show_address = :receipt_show_address,
            receipt_show_contacts = :receipt_show_contacts,
            receipt_barcode_type = :receipt_barcode_type,
            receipt_barcode_value = :receipt_barcode_value,
            low_stock_threshold = :low_stock_threshold
        WHERE id = :id
        LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $updated = $stmt->execute([
            ':site_name_ar'          => $site_name_ar,
            ':site_name_en'          => $site_name_en,
            ':site_description'      => $site_description,
            ':logo'                  => $logo,
            ':favicon'               => $favicon,
            ':about_title'           => $about_title,
            ':about_text'            => $about_text,
            ':about_image'           => $aboutImage,
            ':contact_phone_1'       => $contact_phone_1,
            ':contact_phone_2'       => $contact_phone_2,
            ':contact_whatsapp'      => $contact_whatsapp,
            ':contact_email'         => $contact_email,
            ':contact_address'       => $contact_address,
            ':contact_map_url'       => $contact_map_url,
            ':facebook_url'          => $facebook_url,
            ':instagram_url'         => $instagram_url,
            ':telegram_url'          => $telegram_url,
            ':tiktok_url'            => $tiktok_url,
            ':receipt_store_name'    => $receipt_store_name,
            ':receipt_header_text'   => $receipt_header_text,
            ':receipt_footer_text'   => $receipt_footer_text,
            ':receipt_show_logo'     => $receipt_show_logo,
            ':receipt_show_address'  => $receipt_show_address,
            ':receipt_show_contacts' => $receipt_show_contacts,
            ':receipt_barcode_type'  => $receipt_barcode_type,
            ':receipt_barcode_value' => $receipt_barcode_value,
            ':low_stock_threshold'   => $low_stock_threshold,
            ':id'                    => $id,
        ]);

        if (!$updated) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'تعذر تحديث الإعدادات',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => 'تم تحديث الإعدادات بنجاح',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}