<?php

namespace App\Admin\Controllers;

use App\Admin\Helpers\AdminUrl;
use App\Admin\Models\Product;
use App\Admin\Models\Brand;
use App\Admin\Models\Category;
use PDO;
use PDOException;

class ProductsController
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

        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? 'all');

        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $productModel = new Product($this->db);
        $brandModel = new Brand($this->db);
        $categoryModel = new Category($this->db);

        $totalProducts = $productModel->countAll($search, $status);
        $totalPages = max(1, (int)ceil($totalProducts / $perPage));

        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $perPage;
        }

        $products = $productModel->getAll($search, $status, $perPage, $offset);
        $brands = $brandModel->getAll();
        $categories = $categoryModel->getAll();

        $currentSearch = $search;
        $currentStatus = $status;
        $currentPage = $page;
        $perPageCount = $perPage;
        $productsTotalCount = $totalProducts;
        $productsTotalPages = $totalPages;

        $pageTitle = 'المنتجات';
        $contentView = dirname(__DIR__) . '/Views/products/index.php';

        require dirname(__DIR__) . '/Views/layouts/admin.php';
    }
}