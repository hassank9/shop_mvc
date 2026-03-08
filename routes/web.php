<?php
declare(strict_types=1);

use App\Controllers\HomeController;
use App\Helpers\Response;
use App\Helpers\Url;
use App\Controllers\OrderController;
use App\Controllers\CartController;
use App\Controllers\ProductController;
use App\Controllers\AuthController;
use App\Controllers\CheckoutController;
use App\Admin\Controllers\AuthController as AdminAuthController;
use App\Admin\Controllers\DashboardController as AdminDashboardController;
use App\Admin\Controllers\OrdersController as AdminOrdersController;
use App\Admin\Controllers\OrdersApiController as AdminOrdersApiController;
use App\Admin\Controllers\BrandsController as AdminBrandsController;
use App\Admin\Controllers\BrandsApiController as AdminBrandsApiController;
use App\Admin\Controllers\CategoriesController as AdminCategoriesController;
use App\Admin\Controllers\CategoriesApiController as AdminCategoriesApiController;
use App\Admin\Controllers\ProductsController as AdminProductsController;
use App\Admin\Controllers\ProductsApiController as AdminProductsApiController;
use App\Admin\Controllers\UsersController as AdminUsersController;
use App\Admin\Controllers\UsersApiController as AdminUsersApiController;
use App\Admin\Controllers\SettingsController as AdminSettingsController;
use App\Admin\Controllers\SettingsApiController as AdminSettingsApiController;
use App\Admin\Controllers\HeroController as AdminHeroController;
use App\Admin\Controllers\HeroApiController as AdminHeroApiController;

$router->get('/product', [ProductController::class, 'show']);

/** @var \App\Helpers\Router $router */
$router->get('/', [HomeController::class, 'index']);

// ====================== CSRF TEST ======================
$router->get('/csrf-test', function () {

    $action = htmlspecialchars(Url::to('/csrf-test'), ENT_QUOTES, 'UTF-8');

    $html = '<!doctype html><html lang="ar" dir="rtl"><meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <body class="p-4">
      <div class="container">
        <h4 class="mb-3">اختبار CSRF</h4>

        <form method="POST" action="' . $action . '">
          ' . \App\Helpers\Csrf::input() . '
          <button class="btn btn-primary">ارسال POST</button>
        </form>

        <hr>
        <p class="text-muted mb-0">إذا حذفت hidden input أو غيّرت قيمته لازم يعطيك 419.</p>
      </div>
    </body></html>';

    Response::html($html);
});

$router->post('/csrf-test', function () {
    \App\Helpers\Csrf::verifyOrFail($_POST['_csrf'] ?? null);

    $back = htmlspecialchars(Url::to('/csrf-test'), ENT_QUOTES, 'UTF-8');

    Response::html('<div style="font-family:tahoma;direction:rtl;padding:24px">
      ✅ CSRF OK — POST تم بنجاح
      <br><a href="' . $back . '">رجوع</a>
    </div>');
});


$router->get('/cart', [CartController::class, 'index']);
$router->get('/checkout', [CheckoutController::class, 'show']);
$router->post('/checkout', [CheckoutController::class, 'place']);


$router->get('/api/orders/items', [\App\Controllers\OrderController::class, 'itemsJson']);

$router->get('/my-orders', [\App\Controllers\OrderController::class, 'myOrders']);
$router->post('/order/cancel', [\App\Controllers\OrderController::class, 'cancel']);

$router->get('/order/success', [OrderController::class, 'success']);

// ====================== CART API TEST PAGE ======================
$router->get('/cart-test', function () {

    $csrf = \App\Helpers\Csrf::token();

    $base = \App\Helpers\Url::basePath();
    $apiCart  = \App\Helpers\Url::to('/api/cart');
    $apiAdd   = \App\Helpers\Url::to('/api/cart/add');
    $apiUp    = \App\Helpers\Url::to('/api/cart/update');
    $apiClear = \App\Helpers\Url::to('/api/cart/clear');

    Response::html('
<!doctype html><html lang="ar" dir="rtl"><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<body class="p-4">
<div class="container">

<h4 class="mb-3">اختبار Cart API</h4>
<div class="alert alert-info small">BasePath: <b>' . htmlspecialchars($base, ENT_QUOTES, "UTF-8") . '</b></div>

<div class="d-flex gap-2 mb-3 flex-wrap">
  <a class="btn btn-outline-dark" href="' . htmlspecialchars($apiCart, ENT_QUOTES, "UTF-8") . '" target="_blank">فتح /api/cart</a>
</div>

<div class="card p-3 mb-3">
  <h6 class="fw-bold mb-2">ADD (/api/cart/add)</h6>
  <form method="post" action="' . htmlspecialchars($apiAdd, ENT_QUOTES, "UTF-8") . '" target="_blank">
    <input type="hidden" name="_csrf" value="' . htmlspecialchars($csrf, ENT_QUOTES, "UTF-8") . '">
    <div class="row g-2">
      <div class="col-md-4"><input class="form-control" name="product_id" placeholder="product_id" value="2"></div>
      <div class="col-md-4"><input class="form-control" name="qty" placeholder="qty" value="1"></div>
      <div class="col-md-4"><button class="btn btn-success w-100">Add</button></div>
    </div>
    <div class="text-muted small mt-2">غيّر product_id حسب منتجاتك (مثلاً 1 أو 2 أو 3)</div>
  </form>
</div>

<div class="card p-3 mb-3">
  <h6 class="fw-bold mb-2">UPDATE (/api/cart/update)</h6>
  <form method="post" action="' . htmlspecialchars($apiUp, ENT_QUOTES, "UTF-8") . '" target="_blank">
    <input type="hidden" name="_csrf" value="' . htmlspecialchars($csrf, ENT_QUOTES, "UTF-8") . '">
    <div class="row g-2">
      <div class="col-md-4"><input class="form-control" name="product_id" placeholder="product_id" value="2"></div>
      <div class="col-md-4"><input class="form-control" name="qty" placeholder="qty (0 يحذف)" value="3"></div>
      <div class="col-md-4"><button class="btn btn-primary w-100">Update</button></div>
    </div>
  </form>
</div>

<div class="card p-3">
  <h6 class="fw-bold mb-2">CLEAR (/api/cart/clear)</h6>
  <form method="post" action="' . htmlspecialchars($apiClear, ENT_QUOTES, "UTF-8") . '" target="_blank">
    <input type="hidden" name="_csrf" value="' . htmlspecialchars($csrf, ENT_QUOTES, "UTF-8") . '">
    <button class="btn btn-danger">Clear</button>
  </form>
</div>

</div>
</body></html>');
});

$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/admin/login', [AdminAuthController::class, 'showLogin']);
$router->post('/admin/login', [AdminAuthController::class, 'login']);
$router->get('/admin/logout', [AdminAuthController::class, 'logout']);

$router->get('/admin/dashboard', [AdminDashboardController::class, 'index']);

$router->get('/admin/orders', [AdminOrdersController::class, 'index']);

$router->get('/admin/orders/show', [AdminOrdersController::class, 'show']);

$router->get('/admin/api/orders/show', [AdminOrdersApiController::class, 'show']);

$router->post('/admin/api/orders/update-status', [AdminOrdersApiController::class, 'updateStatus']);


$router->get('/admin/brands', [AdminBrandsController::class, 'index']);

$router->post('/admin/api/brands/store', [AdminBrandsApiController::class, 'store']);
$router->get('/admin/api/brands/show', [AdminBrandsApiController::class, 'show']);
$router->post('/admin/api/brands/update', [AdminBrandsApiController::class, 'update']);
$router->post('/admin/api/brands/delete', [AdminBrandsApiController::class, 'delete']);

$router->post('/admin/api/categories/delete', [AdminCategoriesApiController::class, 'delete']);


$router->get('/admin/categories', [AdminCategoriesController::class, 'index']);

$router->post('/admin/api/categories/store', [AdminCategoriesApiController::class, 'store']);
$router->get('/admin/api/categories/show', [AdminCategoriesApiController::class, 'show']);
$router->post('/admin/api/categories/update', [AdminCategoriesApiController::class, 'update']);


$router->get('/admin/products', [AdminProductsController::class, 'index']);
$router->post('/admin/api/products/store', [AdminProductsApiController::class, 'store']);
$router->get('/admin/api/products/show', [AdminProductsApiController::class, 'show']);
$router->post('/admin/api/products/update', [AdminProductsApiController::class, 'update']);

$router->get('/admin/users', [AdminUsersController::class, 'index']);


$router->post('/admin/api/users/update', [AdminUsersApiController::class, 'update']);
$router->post('/admin/api/users/delete', [AdminUsersApiController::class, 'delete']);

$router->get('/admin/settings', [AdminSettingsController::class, 'index']);
$router->post('/admin/api/settings/update', [AdminSettingsApiController::class, 'update']);

$router->get('/admin/hero', [AdminHeroController::class, 'index']);

$router->post('/admin/api/hero/store', [AdminHeroApiController::class, 'store']);
$router->post('/admin/api/hero/update', [AdminHeroApiController::class, 'update']);
$router->post('/admin/api/hero/delete', [AdminHeroApiController::class, 'delete']);
$router->post('/admin/api/hero/toggle', [AdminHeroApiController::class, 'toggle']);