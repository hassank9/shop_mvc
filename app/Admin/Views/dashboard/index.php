<?php use App\Admin\Helpers\AdminUrl; ?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body style="background:#f5f7fb;">
    <div class="container py-5">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <h1 class="mb-3">مرحبًا <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></h1>
                <p class="mb-3">تم تسجيل الدخول إلى لوحة التحكم بنجاح.</p>

                <ul>
                    <li>اسم المستخدم: <?= htmlspecialchars($_SESSION['admin_username'] ?? '') ?></li>
                    <li>الصلاحية: <?= htmlspecialchars($_SESSION['admin_role'] ?? '') ?></li>
                </ul>

                <a href="<?= htmlspecialchars(AdminUrl::path('/admin/logout')) ?>" class="btn btn-danger mt-3">تسجيل الخروج</a>
            </div>
        </div>
    </div>
</body>
</html>