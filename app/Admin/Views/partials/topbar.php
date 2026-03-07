<style>
    .topbar-box{
        background:#fff;
        border-radius:24px;
        box-shadow:0 10px 30px rgba(15,23,42,.06);
        border:1px solid #eef1f5;
        padding:18px 22px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:16px;
        flex-wrap:wrap;
    }

    .topbar-left{
        display:flex;
        align-items:center;
        gap:12px;
    }

    .topbar-toggle{
        width:46px;
        height:46px;
        border:none;
        border-radius:14px;
        background:#f4f6fa;
        color:#1f2937;
        font-size:20px;
        font-weight:700;
        cursor:pointer;
        transition:.2s ease;
    }

    .topbar-toggle:hover{
        background:#fff1e8;
        color:#ff6a00;
    }

    .topbar-title{
        margin:0;
        font-size:16px;
        font-weight:800;
        color:#111827;
    }

    .topbar-subtitle{
        margin:4px 0 0;
        font-size:14px;
        color:#7b8595;
    }

    .topbar-user{
        display:flex;
        align-items:center;
        gap:12px;
        background:#f9fafb;
        border:1px solid #eef1f5;
        border-radius:18px;
        padding:10px 14px;
    }

    .topbar-avatar{
        width:42px;
        height:42px;
        border-radius:14px;
        background:linear-gradient(135deg,#ff6a00,#ff8c3a);
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:800;
        flex-shrink:0;
        box-shadow:0 8px 18px rgba(255,106,0,.22);
    }

    .topbar-user-name{
        margin:0;
        font-size:14px;
        font-weight:800;
    }

    .topbar-user-role{
        margin:2px 0 0;
        font-size:12px;
        color:#7b8595;
    }

    @media (max-width: 575.98px){
        .topbar-box{
            padding:14px 16px;
            border-radius:18px;
        }

        .topbar-user{
            width:100%;
            justify-content:flex-start;
        }
    }
</style>

<div class="topbar-box">
    <div class="topbar-left">
        <button type="button" class="topbar-toggle" onclick="toggleSidebar()">☰</button>

        <div>
            <h2 class="topbar-title">لوحة التحكم</h2>
            <p class="topbar-subtitle">إدارة المحتوى والطلبات والإعدادات</p>
        </div>
    </div>

    <div class="topbar-user">
        <div class="topbar-avatar">
            <?= htmlspecialchars(mb_substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?>
        </div>

        <div>
            <p class="topbar-user-name"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></p>
            <p class="topbar-user-role"><?= htmlspecialchars($_SESSION['admin_role'] ?? '') ?></p>
        </div>
    </div>
</div>