<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

use App\Helpers\Logger;
use App\Helpers\Request;
use App\Helpers\Router;
use App\Helpers\Session;

require dirname(__DIR__) . '/vendor/autoload.php';

$appConfig = require dirname(__DIR__) . '/config/app.php';
date_default_timezone_set($appConfig['timezone'] ?? 'UTC');

Session::start();

// 3) Error handling (log to storage/logs)
ini_set('display_errors', ($appConfig['env'] ?? 'production') === 'local' ? '1' : '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

set_error_handler(function ($severity, $message, $file, $line) {
    Logger::error('PHP Error', compact('severity','message','file','line'));
    return false;
});

set_exception_handler(function (Throwable $e) {
    Logger::error('Uncaught Exception', [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString(),
    ]);

    http_response_code(500);
    echo "<h3>حدث خطأ داخلي</h3>";
    if (ini_get('display_errors')) {
        echo "<pre>" . htmlspecialchars((string)$e, ENT_QUOTES, 'UTF-8') . "</pre>";
    }
    exit;
});

// 4) Router
$router = new Router();

// 5) Load routes
require dirname(__DIR__) . '/routes/web.php';
require dirname(__DIR__) . '/routes/api.php';

// 6) Dispatch
$router->dispatch(Request::method(), Request::uri());