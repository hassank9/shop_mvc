<?php
declare(strict_types=1);

namespace App\Helpers;

final class Money
{
    public static function iqd(float|int|string|null $amount): string
    {
        $value = (float)($amount ?? 0);
        return number_format($value, 0) . ' د.ع ';
    }
}