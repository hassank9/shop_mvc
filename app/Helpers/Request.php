<?php
declare(strict_types=1);

namespace App\Helpers;

final class Request
{
    public static function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public static function uri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = strtok($uri, '?') ?: '/'; // remove query string

        // Base path = folder of public/index.php (مثال: /shop_mvc/public)
        $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');

        // إذا كان المسار يبدأ بالـ basePath نشيله
        if ($basePath !== '' && $basePath !== '/' && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
            if ($uri === false || $uri === '') $uri = '/';
        }

        return $uri;
    }

    public static function isAjax(): bool
    {
        $h = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
        return strtolower($h) === 'xmlhttprequest';
    }
}