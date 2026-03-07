<?php
declare(strict_types=1);

namespace App\Helpers;

final class Url
{
    // يرجّع /shop_mvc/public (أو أي مسار حسب مكان public)
    public static function basePath(): string
    {
        $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        return $base === '' ? '' : $base;
    }

    // يبني رابط صحيح داخل المشروع
    public static function to(string $path): string
    {
        $path = '/' . ltrim($path, '/');
        return self::basePath() . $path;
    }
}