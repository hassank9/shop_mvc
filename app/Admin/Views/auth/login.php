<?php use App\Admin\Helpers\AdminUrl; ?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الإدارة</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: Tahoma, Arial, sans-serif;
        }

        .login-page {
            min-height: 100vh;
        }

        .login-card {
            border: 0;
            border-radius: 22px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .login-card .card-body {
            padding: 32px;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #222;
        }

        .login-subtitle {
            color: #777;
            margin-bottom: 24px;
        }

        .form-control {
            min-height: 50px;
            border-radius: 14px;
        }

        .btn-login {
            min-height: 50px;
            border: 0;
            border-radius: 14px;
            background: #ff6a00;
            color: #fff;
            font-weight: 700;
        }

        .btn-login:hover {
            background: #e85f00;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center login-page">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5">
            <div class="card login-card">
                <div class="card-body">
                    <h1 class="login-title mb-2">لوحة التحكم</h1>
                    <p class="login-subtitle">سجّل الدخول للوصول إلى لوحة الإدارة</p>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= htmlspecialchars(AdminUrl::path('/admin/login')) ?>">
                        <div class="mb-3">
                            <label class="form-label">اسم المستخدم</label>
                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">كلمة المرور</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-login">
                                تسجيل الدخول
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>