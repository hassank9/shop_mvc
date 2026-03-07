<?php
declare(strict_types=1);

namespace App\Helpers;

final class Csrf
{
    public static function token(): string
    {
        Session::start();

        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return (string)$_SESSION['_csrf'];
    }

    public static function input(): string
    {
        $t = self::token();
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($t, ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function verifyOrFail(?string $token): void
    {
        Session::start();

        $real = $_SESSION['_csrf'] ?? '';
        if (!$token || !is_string($token) || !hash_equals($real, $token)) {
            http_response_code(419); // Laravel-style: Page Expired
            echo "CSRF token mismatch";
            exit;
        }
    }
}