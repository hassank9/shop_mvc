<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Csrf;
use App\Helpers\Url;
use App\Models\Order;

final class OrderController extends Controller
{
    public function myOrders(): void
    {
        $uid = (int)($_SESSION['user_id'] ?? 0);
        if ($uid <= 0) {
            header('Location: ' . Url::to('/login?return=' . urlencode(Url::to('/my-orders'))), true, 302);
            exit;
        }

        $orders = Order::listByUser($uid);

        $this->view('orders/my', [
            'title' => 'طلباتي',
            'orders' => $orders,
        ]);
    }

    public function cancel(): void
    {
        Csrf::verifyOrFail($_POST['_csrf'] ?? null);

        $uid = (int)($_SESSION['user_id'] ?? 0);
        if ($uid <= 0) {
            header('Location: ' . Url::to('/login?return=' . urlencode(Url::to('/my-orders'))), true, 302);
            exit;
        }

        $orderId = (int)($_POST['order_id'] ?? 0);
        if ($orderId <= 0) {
            header('Location: ' . Url::to('/my-orders'), true, 302);
            exit;
        }

        Order::cancelIfPending($orderId, $uid);

        header('Location: ' . Url::to('/my-orders'), true, 302);
        exit;
    }


public function success(): void
{
    $uid = (int)($_SESSION['user_id'] ?? 0);
    if ($uid <= 0) {
        header('Location: ' . Url::to('/login?return=' . urlencode(Url::to('/my-orders'))), true, 302);
        exit;
    }

    // ممكن نخزن فلاش بسيط بالسيشن
    $_SESSION['flash_success'] = '✅ تم إنشاء الطلب بنجاح';

    header('Location: ' . Url::to('/my-orders'), true, 302);
    exit;
}


public function itemsJson(): void
{
    $uid = (int)($_SESSION['user_id'] ?? 0);
    if ($uid <= 0) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'message' => 'غير مسجل']);
        exit;
    }

    $orderId = (int)($_GET['id'] ?? 0);
    if ($orderId <= 0) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'message' => 'طلب غير صالح']);
        exit;
    }

    $items = \App\Models\Order::itemsByOrder($orderId, $uid);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => true, 'items' => $items], JSON_UNESCAPED_UNICODE);
    exit;
}

}