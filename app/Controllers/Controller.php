<?php
declare(strict_types=1);

namespace App\Controllers;

abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        $viewPath = dirname(__DIR__) . '/Views/' . trim($view, '/') . '.php';
        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo "View not found: " . htmlspecialchars($viewPath);
            exit;
        }

        extract($data, EXTR_SKIP);
        require $viewPath;
    }
}