<?php
declare(strict_types=1);

namespace App\Middlewares;

use App\Helpers\Url;

final class AuthMiddleware
{
    public static function requireUser(): void
    {
        if (!isset($_SESSION['user_id']) || (int)$_SESSION['user_id'] <= 0) {
            $return = $_SERVER['REQUEST_URI'] ?? Url::to('/');
            $to = Url::to('/login?return=' . urlencode($return));
            header("Location: $to", true, 302);
            exit;
        }
    }
}