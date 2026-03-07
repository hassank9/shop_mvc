<?php

namespace App\Admin\Controllers;

use App\Admin\Helpers\AdminUrl;
use App\Admin\Models\Brand;
use PDO;
use PDOException;

class BrandsController
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

        $brandModel = new Brand($this->db);
        $brands = $brandModel->getAll();

        $pageTitle = 'البراندات';
        $contentView = dirname(__DIR__) . '/Views/brands/index.php';

        require dirname(__DIR__) . '/Views/layouts/admin.php';
    }
}