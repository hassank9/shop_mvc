<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Csrf;
use App\Helpers\Url;
use App\Models\User;
use App\Models\Order;

final class CheckoutController extends Controller
{
    public function show(): void
    {
        if (!Auth::check()) {
            $ret = urlencode($_SERVER['REQUEST_URI'] ?? Url::to('/checkout'));
            header('Location: ' . Url::to('/login?return=' . $ret), true, 302);
            exit;
        }

        $uid = Auth::id();
        $user = User::findById($uid);
        if (!$user) {
            // الأفضل توجيه المستخدم لصفحة تسجيل الدخول بدل /logout لأنه POST
            header('Location: ' . Url::to('/login'), true, 302);
            exit;
        }

        // ====== Cart Summary for Checkout ======
$cart = \App\Helpers\Cart::items(); // [productId => qty]

$cartLines = [];
$cartTotal = 0.0;

if (!empty($cart)) {
    $products = \App\Models\Product::byIds(array_keys($cart)); // يجلب price/qty
    $byId = [];
    foreach ($products as $p) {
        $byId[(int)$p['id']] = $p;
    }

    foreach ($cart as $pid => $qty) {
        $pid = (int)$pid;
        $qty = (int)$qty;
        if ($qty <= 0) continue;

        if (!isset($byId[$pid])) continue;

        $p = $byId[$pid];
        $unit = (float)$p['price'];
        $lineTotal = $unit * $qty;

        $cartLines[] = [
            'id' => $pid,
            'name' => (string)$p['name'],
            'slug' => (string)$p['slug'],
            'brand_name' => (string)($p['brand_name'] ?? ''),
            'qty' => $qty,
            'unit_price' => $unit,
            'line_total' => $lineTotal,
        ];

        $cartTotal += $lineTotal;
    }

    $cartTotal = round($cartTotal, 2);
}

$this->view('checkout/index', [
    'title' => 'إتمام الطلب',
    'user'  => $user,
    'cartLines' => $cartLines,
    'cartTotal' => $cartTotal,
]);
    }

    public function place(): void
    {
        Csrf::verifyOrFail($_POST['_csrf'] ?? null);

        // لازم يكون مسجل
        $uid = Auth::id();
        if ($uid <= 0) {
            $return = Url::to('/checkout');
            header('Location: ' . Url::to('/login?return=' . urlencode($return)), true, 302);
            exit;
        }

        // اجلب بيانات المستخدم من الجدول (حتى ما نطلبها من الفورم)
        $user = User::findById($uid);
        if (!$user) {
            header('Location: ' . Url::to('/login'), true, 302);
            exit;
        }

        $notes = trim((string)($_POST['notes'] ?? ''));

        try {
            // ✅ هنا التعديل: تمرير user_id كأول باراميتر
            $orderId = Order::createFromCart(
                (int)$uid,
                (string)$user['full_name'],
                (string)$user['phone'],
                $notes
            );

            header('Location: ' . Url::to('/order/success?id=' . $orderId), true, 302);
            exit;

        } catch (\Throwable $e) {
            $this->view('checkout/index', [
                'title' => 'إتمام الطلب',
                'user'  => $user,
                'error' => $e->getMessage(),
            ]);
        }
    }
}