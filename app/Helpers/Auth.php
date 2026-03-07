<?php
declare(strict_types=1);

namespace App\Helpers;

final class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] > 0;
    }

    public static function id(): int
    {
        return (int)($_SESSION['user_id'] ?? 0);
    }
}