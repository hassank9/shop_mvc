<?php
declare(strict_types=1);

namespace App\Helpers;

final class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function get(string $path, $handler): void
    {
        $this->routes['GET'][$this->normalize($path)] = $handler;
    }

    public function post(string $path, $handler): void
    {
        $this->routes['POST'][$this->normalize($path)] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $method = strtoupper($method);
        $path = $this->normalize($uri);

        $handler = $this->routes[$method][$path] ?? null;

        if (!$handler) {
            Response::html($this->notFoundPage($path), 404);
        }

        if (is_callable($handler)) {
            $handler();
            return;
        }

        if (is_array($handler) && count($handler) === 2) {
            [$class, $action] = $handler;
            if (class_exists($class)) {
                $obj = new $class();
                if (method_exists($obj, $action)) {
                    $obj->$action();
                    return;
                }
            }
        }

        Response::html($this->notFoundPage($path), 404);
    }

    private function normalize(string $path): string
    {
        $path = '/' . trim($path, '/');
        return $path === '/' ? '/' : $path;
    }

    private function notFoundPage(string $path): string
    {
        return "<!doctype html><html lang='ar' dir='rtl'><meta charset='utf-8'><title>404</title>
        <body style='font-family:Tahoma,Arial;direction:rtl;padding:24px'>
        <h2>404 - الصفحة غير موجودة</h2><p>المسار: <code>" . htmlspecialchars($path, ENT_QUOTES, 'UTF-8') . "</code></p>
        </body></html>";
    }
}