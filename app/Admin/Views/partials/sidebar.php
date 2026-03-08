<?php
use App\Admin\Helpers\AdminUrl;

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

function isAdminActive(string $needle, string $currentPath): string {
    return str_contains($currentPath, $needle) ? 'active' : '';
}
?>
<style>
    .brand-box{
        display:flex;
        align-items:center;
        gap:12px;
        margin-bottom:22px;
        padding:6px 4px 14px;
        border-bottom:1px solid #eef1f5;
    }

    .brand-logo{
        width:44px;
        height:44px;
        border-radius:14px;
        background:linear-gradient(135deg,#ff6a00,#ff8c3a);
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:800;
        box-shadow:0 10px 20px rgba(255,106,0,.25);
        flex-shrink:0;
    }

    .brand-title{
        font-size:28px;
        font-weight:800;
        margin:0;
        line-height:1;
    }

    .brand-subtitle{
        color:#8a94a6;
        font-size:13px;
        margin-top:4px;
    }

    .sidebar-title{
        font-size:12px;
        color:#98a2b3;
        font-weight:800;
        margin:18px 8px 10px;
    }

    .sidebar-link{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        text-decoration:none;
        color:#374151;
        padding:14px 16px;
        border-radius:18px;
        margin-bottom:10px;
        font-weight:700;
        transition:.2s ease;
        border:1px solid transparent;
        background:#fff;
    }

    .sidebar-link:hover{
        background:#fff7f1;
        color:#ff6a00;
        border-color:#ffe3cf;
    }

    .sidebar-link.active{
        background:linear-gradient(135deg,#ff6a00,#ff8533);
        color:#fff;
        box-shadow:0 10px 22px rgba(255,106,0,.22);
    }

    .sidebar-link-main{
        display:flex;
        align-items:center;
        gap:12px;
        min-width:0;
    }

    .sidebar-icon{
        width:38px;
        height:38px;
        border-radius:12px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#f4f6fa;
        color:#374151;
        font-size:18px;
        flex-shrink:0;
    }

    .sidebar-link.active .sidebar-icon{
        background:rgba(255,255,255,.18);
        color:#fff;
    }

    .sidebar-link:hover .sidebar-icon{
        background:#fff;
        color:#ff6a00;
    }

    .sidebar-text{
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    .sidebar-footer{
        border-top:1px solid #eef1f5;
        margin-top:18px;
        padding-top:18px;
    }

    .logout-link{
        color:#dc3545;
    }

    .logout-link .sidebar-icon{
        color:#dc3545;
        background:#fff5f5;
    }

    .logout-link:hover{
        background:#fff5f5;
        color:#dc3545;
        border-color:#ffd7dc;
    }
</style>

<div class="brand-box">
    <div class="brand-logo">A</div>
    <div>
        <div class="brand-title">لوحة الإدارة</div>
        <div class="brand-subtitle">Admin Panel</div>
    </div>
</div>

<div class="sidebar-title">القائمة الرئيسية</div>

<a class="sidebar-link <?= isAdminActive('/admin/dashboard', $currentPath) ?>"
   href="<?= htmlspecialchars(AdminUrl::path('/admin/dashboard')) ?>">
    <span class="sidebar-link-main">
        <span class="sidebar-icon">⌂</span>
        <span class="sidebar-text">الرئيسية</span>
    </span>
</a>

<a class="sidebar-link <?= isAdminActive('/admin/categories', $currentPath) ?>"
   href="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/categories')) ?>">
    <span class="sidebar-link-main">
        <span class="sidebar-icon">🗂</span>
        <span class="sidebar-text">الأصناف</span>
    </span>
</a>

<a class="sidebar-link <?= isAdminActive('/admin/brands', $currentPath) ?>"
   href="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/brands')) ?>">
    <span class="sidebar-link-main">
        <span class="sidebar-icon">🏷</span>
        <span class="sidebar-text">البراندات</span>
    </span>
</a>

<a class="sidebar-link <?= isAdminActive('/admin/products', $currentPath) ?>"
   href="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/products')) ?>">
    <span class="sidebar-link-main">
        <span class="sidebar-icon">📦</span>
        <span class="sidebar-text">المنتجات</span>
    </span>
</a>

<a class="sidebar-link <?= isAdminActive('/admin/orders', $currentPath) ?>"
   href="<?= htmlspecialchars(AdminUrl::path('/admin/orders')) ?>">
    <span class="sidebar-link-main">
        <span class="sidebar-icon">🧾</span>
        <span class="sidebar-text">الطلبات</span>
    </span>
</a>

<a class="sidebar-link <?= isAdminActive('/admin/settings', $currentPath) ?>"
   href="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/settings')) ?>">
    <span class="sidebar-link-main">
        <span class="sidebar-icon">⚙️</span>
        <span class="sidebar-text">الإعدادات</span>
    </span>
</a>

<a class="sidebar-link <?= isAdminActive('/admin/hero', $currentPath) ?>"
   href="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/hero')) ?>">
    <span class="sidebar-link-main">
        <span class="sidebar-icon">🖼</span>
        <span class="sidebar-text">الهيرو</span>
    </span>
</a>

<div class="sidebar-footer">
    <a class="sidebar-link logout-link"
       href="<?= htmlspecialchars(AdminUrl::path('/admin/logout')) ?>">
        <span class="sidebar-link-main">
            <span class="sidebar-icon">⇦</span>
            <span class="sidebar-text sidebar-footer-text">تسجيل الخروج</span>
        </span>
    </a>
</div>