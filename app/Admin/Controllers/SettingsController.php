<?php

namespace App\Admin\Controllers;

use App\Admin\Helpers\AdminUrl;
use PDO;
use PDOException;

class SettingsController
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

        $stmt = $this->db->query("SELECT * FROM settings ORDER BY id ASC LIMIT 1");
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);

        $pageTitle = 'الإعدادات';
        $contentView = dirname(__DIR__) . '/Views/settings/index.php';

        require dirname(__DIR__) . '/Views/layouts/admin.php';
    }

    public function update(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['admin_id'])) {
        header('Location: ' . AdminUrl::path('/admin/login'));
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . AdminUrl::path('/admin/settings'));
        exit;
    }

    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($id <= 0) {
        $_SESSION['admin_error'] = 'معرف الإعدادات غير صالح.';
        header('Location: ' . AdminUrl::path('/admin/settings'));
        exit;
    }

    $site_name_ar         = trim($_POST['site_name_ar'] ?? '');
    $site_name_en         = trim($_POST['site_name_en'] ?? '');
    $site_description     = trim($_POST['site_description'] ?? '');

    $about_title          = trim($_POST['about_title'] ?? '');
    $about_text           = trim($_POST['about_text'] ?? '');

    $contact_phone_1      = trim($_POST['contact_phone_1'] ?? '');
    $contact_phone_2      = trim($_POST['contact_phone_2'] ?? '');
    $contact_whatsapp     = trim($_POST['contact_whatsapp'] ?? '');
    $contact_email        = trim($_POST['contact_email'] ?? '');
    $contact_address      = trim($_POST['contact_address'] ?? '');
    $contact_map_url      = trim($_POST['contact_map_url'] ?? '');

    $facebook_url         = trim($_POST['facebook_url'] ?? '');
    $instagram_url        = trim($_POST['instagram_url'] ?? '');
    $telegram_url         = trim($_POST['telegram_url'] ?? '');
    $tiktok_url           = trim($_POST['tiktok_url'] ?? '');

    $receipt_store_name   = trim($_POST['receipt_store_name'] ?? '');
    $receipt_header_text  = trim($_POST['receipt_header_text'] ?? '');
    $receipt_footer_text  = trim($_POST['receipt_footer_text'] ?? '');
    $receipt_show_logo    = isset($_POST['receipt_show_logo']) ? 1 : 0;
    $receipt_show_address = isset($_POST['receipt_show_address']) ? 1 : 0;
    $receipt_show_contacts= isset($_POST['receipt_show_contacts']) ? 1 : 0;
    $receipt_barcode_type = trim($_POST['receipt_barcode_type'] ?? 'qr');
    $receipt_barcode_value= trim($_POST['receipt_barcode_value'] ?? '');
    $low_stock_threshold  = isset($_POST['low_stock_threshold']) ? (int) $_POST['low_stock_threshold'] : 3;

    if (!in_array($receipt_barcode_type, ['barcode', 'qr'], true)) {
        $receipt_barcode_type = 'qr';
    }

    if ($low_stock_threshold < 0) {
        $low_stock_threshold = 0;
    }

    $sql = "UPDATE settings SET
                site_name_ar = :site_name_ar,
                site_name_en = :site_name_en,
                site_description = :site_description,
                about_title = :about_title,
                about_text = :about_text,
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
    $stmt->execute([
        ':site_name_ar'          => $site_name_ar,
        ':site_name_en'          => $site_name_en,
        ':site_description'      => $site_description,
        ':about_title'           => $about_title,
        ':about_text'            => $about_text,
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

    $_SESSION['admin_success'] = 'تم تحديث الإعدادات بنجاح.';
    header('Location: ' . AdminUrl::path('/admin/settings'));
    exit;
}
}