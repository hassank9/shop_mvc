<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Csrf;
use App\Helpers\Url;
use App\Models\User;

final class AuthController extends Controller
{
    /**
     * يرجّع مسار داخلي آمن داخل نفس المشروع فقط.
     * - يمنع redirect خارجي
     * - يعالج HTTP_REFERER أو URL كامل ويأخذ path فقط
     * - يمنع تكرار basePath مثل /shop_mvc/public/shop_mvc/public
     */
private function safeReturn(string $ret): string
{
    $ret = trim($ret);

    // إذا جاي URL كامل خذ الـ path فقط
    $p = parse_url($ret);
    if (is_array($p) && isset($p['path'])) {
        $ret = (string)$p['path'];
    }

    if ($ret === '' || $ret[0] !== '/') {
        return '/';
    }

    // امنع // أو بروتوكول
    if (str_starts_with($ret, '//') || str_contains($ret, '://')) {
        return '/';
    }

    // ✅ اسمح فقط بمسارات داخل مشروعك
    $base = rtrim(Url::basePath(), '/'); // مثال: /shop_mvc/public

    // لو مشروعك داخل مجلد (basePath مو فاضي) لازم الـ ret يبدأ به
    if ($base !== '') {
        if ($ret === $base) return '/';

        if (!str_starts_with($ret, $base . '/')) {
            return '/'; // مثل /dashboard ممنوع
        }

        // حوله لمسار داخلي داخل المشروع (بدون basePath)
        $ret = substr($ret, strlen($base));
        if ($ret === '') $ret = '/';
    }

    return $ret;
}

    public function showRegister(): void
    {
        $return = (string)($_GET['return'] ?? ($_SERVER['HTTP_REFERER'] ?? Url::to('/')));
        $return = $this->safeReturn($return);

        $this->view('auth/register', [
            'title'  => 'إنشاء حساب',
            'return' => $return
        ]);
    }

    public function register(): void
    {
        Csrf::verifyOrFail($_POST['_csrf'] ?? null);

        $fullName = trim((string)($_POST['full_name'] ?? ''));
        $phone    = trim((string)($_POST['phone'] ?? ''));
        $address  = trim((string)($_POST['address'] ?? ''));
        $pass     = (string)($_POST['password'] ?? '');
        $return   = $this->safeReturn((string)($_POST['return'] ?? Url::to('/')));

        if ($fullName === '' || mb_strlen($fullName) < 3) {
            $this->view('auth/register', ['title'=>'إنشاء حساب','error'=>'الاسم غير صالح','return'=>$return]); return;
        }
        if ($phone === '' || mb_strlen($phone) < 8 || mb_strlen($phone) > 30) {
            $this->view('auth/register', ['title'=>'إنشاء حساب','error'=>'رقم الهاتف غير صالح','return'=>$return]); return;
        }
        if ($address === '' || mb_strlen($address) < 6) {
            $this->view('auth/register', ['title'=>'إنشاء حساب','error'=>'العنوان غير صالح','return'=>$return]); return;
        }
        if (mb_strlen($pass) < 6) {
            $this->view('auth/register', ['title'=>'إنشاء حساب','error'=>'كلمة المرور 6 أحرف على الأقل','return'=>$return]); return;
        }

        if (User::findByPhone($phone)) {
            $this->view('auth/register', ['title'=>'إنشاء حساب','error'=>'رقم الهاتف مسجل مسبقًا','return'=>$return]); return;
        }

        $id = User::create($fullName, $phone, $address, $pass);

        session_regenerate_id(true);
        $_SESSION['user_id'] = $id;

        header('Location: ' . Url::to($return), true, 302);
        exit;
    }

    public function showLogin(): void
    {
        $return = (string)($_GET['return'] ?? ($_SERVER['HTTP_REFERER'] ?? Url::to('/')));
        $return = $this->safeReturn($return);

        $this->view('auth/login', [
            'title'  => 'تسجيل الدخول',
            'return' => $return
        ]);
    }

    public function login(): void
    {
        Csrf::verifyOrFail($_POST['_csrf'] ?? null);

        $phone  = trim((string)($_POST['phone'] ?? ''));
        $pass   = (string)($_POST['password'] ?? '');
        $return = $this->safeReturn((string)($_POST['return'] ?? Url::to('/')));

        $u = User::findByPhone($phone);
        if (!$u || !password_verify($pass, (string)$u['password_hash'])) {
            $this->view('auth/login', ['title'=>'تسجيل الدخول','error'=>'بيانات الدخول غير صحيحة','return'=>$return]); return;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$u['id'];

        header('Location: ' . Url::to($return), true, 302);
        exit;
    }

    public function logout(): void
    {
        Csrf::verifyOrFail($_POST['_csrf'] ?? null);

        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p["path"], $p["domain"], $p["secure"], $p["httponly"]);
        }
        session_destroy();

        header('Location: ' . Url::to('/'), true, 302);
        exit;
    }
}