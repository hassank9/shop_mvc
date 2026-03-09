<?php
declare(strict_types=1);

namespace App\Helpers;

final class Url
{
    public static function basePath(): string
    {
        $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        return $base === '' ? '' : $base;
    }

    public static function to(string $path): string
    {
        $path = '/' . ltrim($path, '/');
        return self::basePath() . $path;
    }

    public static function file(string $path = ''): string
    {
        $path = trim(str_replace('\\', '/', $path));

        if ($path === '') {
            return '';
        }

        // روابط كاملة
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $base = rtrim(self::basePath(), '/');

        // لو المسار من النوع القديم: /shop_mvc/public/uploads/...
        if (strpos($path, '/public/uploads/') !== false) {
            $pos = strpos($path, '/public/uploads/');
            $path = substr($path, $pos + 7); // تصبح /uploads/...
        }

        // لو المسار من النوع القديم المباشر: /shop_mvc/uploads/...
        if (strpos($path, '/uploads/') !== 0 && strpos($path, 'uploads/') === 0) {
            $path = '/' . $path;
        }

        // لو هو أصلًا /uploads/...
        if (strpos($path, '/uploads/') === 0) {
            return $base . $path;
        }

        // أي مسار نسبي آخر
        return $base . '/' . ltrim($path, '/');
    }
}