<?php

namespace App\Admin\Helpers;

class AdminUrl
{
    public static function path(string $path = ''): string
    {
        $base = '/shop_mvc/public';
        $path = '/' . ltrim($path, '/');
        return $base . $path;
    }
}