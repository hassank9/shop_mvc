<?php

namespace App\Admin\Controllers;

use App\Admin\Helpers\AdminUrl;
use App\Admin\Models\Category;
use PDO;
use PDOException;

class CategoriesController
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

        $categoryModel = new Category($this->db);
        $categories = $categoryModel->getAll();

        $pageTitle = 'الأصناف';
        $contentView = dirname(__DIR__) . '/Views/categories/index.php';

        require dirname(__DIR__) . '/Views/layouts/admin.php';
    }
}   