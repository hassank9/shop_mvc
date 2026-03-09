<?php

namespace App\Admin\Helpers;

use App\Helpers\Url;

class AdminUrl
{
    public static function basePath(): string
    {
        return rtrim(Url::basePath(), '/');
    }

    public static function path(string $path = ''): string
    {
        return Url::to($path);
    }

    public static function file(string $path = ''): string
    {
        return Url::file($path);
    }
}