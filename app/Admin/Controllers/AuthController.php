<?php


namespace App\Admin\Controllers;

use App\Admin\Models\Admin;
use PDO;
use PDOException;
use App\Admin\Helpers\AdminUrl;


class AuthController
{
    protected ?PDO $db = null;
    protected ?Admin $adminModel = null;

    public function __construct()
    {
        $this->db = $this->createAdminConnection();
        $this->adminModel = new Admin($this->db);
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

    public function showLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['admin_id'])) {
            header('Location: ' . AdminUrl::path('/admin/dashboard'));
            exit;
        }

        $error = null;
        require_once dirname(__DIR__) . '/Views/auth/login.php';
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $error = 'يرجى إدخال اسم المستخدم وكلمة المرور';
            require_once dirname(__DIR__) . '/Views/auth/login.php';
            return;
        }

        $admin = $this->adminModel->findByUsername($username);

        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            $error = 'بيانات الدخول غير صحيحة';
            require_once dirname(__DIR__) . '/Views/auth/login.php';
            return;
        }

        $_SESSION['admin_id'] = (int) $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_role'] = $admin['role'];

        header('Location: ' . AdminUrl::path('/admin/dashboard'));
        exit;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header('Location: ' . AdminUrl::path('/admin/login'));
        exit;
    }
}