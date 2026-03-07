<style>

    .mini-badge.danger{
    background:#ffe5e5;
    color:#dc3545;
}

.mini-badge.warning{
    background:#fff3e8;
    color:#ff6a00;
}

    .dashboard-header{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:24px;
    }

    .dashboard-title{
        font-size:20px;
        font-weight:800;
        margin:0 0 6px;
        color:#111827;
    }

    .dashboard-subtitle{
        margin:0;
        color:#7b8595;
        font-size:14px;
    }

.stats-grid{
    display:grid;
    grid-template-columns:repeat(4, minmax(0,1fr));
    gap:18px;
    margin-bottom:22px;
}

    .stat-card{
        position:relative;
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:22px;
        padding:20px;
        min-height:150px;
        overflow:hidden;
        box-shadow:0 10px 25px rgba(15,23,42,.04);
    }

    .stat-card.dark{
        background:linear-gradient(135deg,#20232c,#111827);
        border:none;
        color:#fff;
        box-shadow:0 16px 32px rgba(17,24,39,.18);
    }

    .stat-card.primary{
        background:linear-gradient(135deg,#ff6a00,#ff8f3c);
        border:none;
        color:#fff;
        box-shadow:0 16px 32px rgba(255,106,0,.22);
    }

    .stat-icon{
        width:56px;
        height:56px;
        border-radius:18px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:24px;
        margin-bottom:18px;
        background:#f4f6fa;
        color:#1f2937;
    }

    .stat-card.dark .stat-icon,
    .stat-card.primary .stat-icon{
        background:rgba(255,255,255,.16);
        color:#fff;
    }

    .stat-label{
        margin:0 0 8px;
        font-size:14px;
        font-weight:700;
        color:#7b8595;
    }

    .stat-card.dark .stat-label,
    .stat-card.primary .stat-label{
        color:rgba(255,255,255,.82);
    }

    .stat-value{
        margin:0;
        font-size:34px;
        font-weight:800;
        line-height:1;
    }

    .stat-note{
        position:absolute;
        left:20px;
        bottom:18px;
        font-size:13px;
        font-weight:700;
        color:#10b981;
    }

    .stat-card.dark .stat-note,
    .stat-card.primary .stat-note{
        color:#fff;
        opacity:.9;
    }

    .dashboard-panels{
        display:grid;
        grid-template-columns:2fr 1fr;
        gap:20px;
    }

    .panel-card{
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:24px;
        padding:22px;
        box-shadow:0 10px 25px rgba(15,23,42,.04);
    }

    .panel-title{
        margin:0 0 6px;
        font-size:18px;
        font-weight:800;
        color:#111827;
    }

    .panel-subtitle{
        margin:0 0 18px;
        color:#7b8595;
        font-size:14px;
    }

    .mini-table{
        width:100%;
        border-collapse:collapse;
    }

    .mini-table th,
    .mini-table td{
        padding:14px 10px;
        border-bottom:1px solid #eef1f5;
        text-align:right;
        font-size:14px;
    }

    .mini-table th{
        color:#98a2b3;
        font-size:12px;
        font-weight:800;
    }

    .mini-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:6px 10px;
        border-radius:999px;
        background:#fff3e8;
        color:#ff6a00;
        font-size:12px;
        font-weight:800;
    }

    .activity-list{
        display:flex;
        flex-direction:column;
        gap:14px;
    }

    .activity-item{
        display:flex;
        align-items:flex-start;
        gap:12px;
        padding:14px;
        border:1px solid #eef1f5;
        border-radius:18px;
        background:#fafbfc;
    }

    .activity-icon{
        width:42px;
        height:42px;
        border-radius:14px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#fff1e8;
        color:#ff6a00;
        font-size:18px;
        flex-shrink:0;
    }

    .activity-title{
        margin:0 0 4px;
        font-size:14px;
        font-weight:800;
        color:#111827;
    }

    .activity-time{
        margin:0;
        font-size:12px;
        color:#8a94a6;
    }

    @media (max-width: 1199.98px){
        .stats-grid{
            grid-template-columns:repeat(2, minmax(0,1fr));
        }

        .dashboard-panels{
            grid-template-columns:1fr;
        }
    }

    @media (max-width: 575.98px){
        .stats-grid{
            grid-template-columns:1fr;
        }

        .stat-card{
            min-height:auto;
        }

        .stat-note{
            position:static;
            display:block;
            margin-top:12px;
        }
    }
</style>

<div class="dashboard-header">
    <div>
        <h1 class="dashboard-title">الرئيسية</h1>
        <p class="dashboard-subtitle">نظرة عامة حديثة على أداء المتجر والطلبات والمستخدمين.</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-icon">👥</div>
        <p class="stat-label">عدد المستخدمين</p>
        <h3 class="stat-value"><?= (int)($stats['users_count'] ?? 0) ?></h3>
        <span class="stat-note">إجمالي الحسابات</span>
    </div>

    <div class="stat-card dark">
        <div class="stat-icon">🧾</div>
        <p class="stat-label">إجمالي الطلبات</p>
        <h3 class="stat-value"><?= (int)($stats['orders_count'] ?? 0) ?></h3>
        <span class="stat-note">كل الطلبات المسجلة</span>
    </div>

    <div class="stat-card dark">
        <div class="stat-icon">⏳</div>
        <p class="stat-label">طلبات معلقة</p>
        <h3 class="stat-value"><?= (int)($stats['pending_orders_count'] ?? 0) ?></h3>
        <span class="stat-note">بانتظار المعالجة</span>
    </div>

    <div class="stat-card dark">
        <div class="stat-icon">✅</div>
        <p class="stat-label">تم التسليم</p>
        <h3 class="stat-value"><?= (int)($stats['delivered_orders_count'] ?? 0) ?></h3>
        <span class="stat-note">طلبات مكتملة</span>
    </div>

    <div class="stat-card">
        <div class="stat-icon">✔️</div>
        <p class="stat-label">تمت الموافقة</p>
        <h3 class="stat-value"><?= (int)($stats['approved_orders_count'] ?? 0) ?></h3>
        <span class="stat-note">طلبات جاهزة للتجهيز</span>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🚚</div>
        <p class="stat-label">مع المندوب</p>
        <h3 class="stat-value"><?= (int)($stats['out_for_delivery_orders_count'] ?? 0) ?></h3>
        <span class="stat-note">قيد التوصيل</span>
    </div>

    <div class="stat-card">
        <div class="stat-icon">❌</div>
        <p class="stat-label">الطلبات الملغاة</p>
        <h3 class="stat-value"><?= (int)($stats['cancelled_orders_count'] ?? 0) ?></h3>
        <span class="stat-note">طلبات ألغيت</span>
    </div>

    <div class="stat-card">
    <div class="stat-icon">📈</div>
    <p class="stat-label">صافي الربح</p>
    <h3 class="stat-value"><?= number_format((float)($stats['total_profit'] ?? 0), 2) ?></h3>
    <span class="stat-note">بدون الطلبات الملغاة</span>
</div>

    <div class="stat-card primary">
        <div class="stat-icon">💰</div>
        <p class="stat-label">إجمالي المبيعات</p>
        <h3 class="stat-value"><?= number_format((float)($stats['total_sales'] ?? 0), 2) ?></h3>
        <span class="stat-note">مجموع كل الطلبات</span>
    </div>
</div>
    
</div>

<div class="dashboard-panels">
    <div class="panel-card">
        <h3 class="panel-title">المنتجات القريبة من النفاد</h3>
        <p class="panel-subtitle">
    المنتجات التي كميتها أقل من أو تساوي
    <strong><?= (int)($stats['low_stock_threshold'] ?? 3) ?></strong>
</p>

        <div class="table-responsive">
            <table class="mini-table">
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>البراند</th>
                        <th>الكمية</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
<?php $lowStockProducts = $stats['low_stock_products'] ?? []; ?>

<?php if (!empty($lowStockProducts)): ?>
    <?php foreach ($lowStockProducts as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['product_name'] ?? '') ?></td>
            <td>—</td>
            <td><?= (int)($item['qty'] ?? 0) ?></td>
            <td>
                <?php $qty = (int)($item['qty'] ?? 0); ?>
<span class="mini-badge <?= $qty <= 0 ? 'danger' : 'warning' ?>">
    <?= $qty <= 0 ? 'نافد' : 'منخفض' ?>
</span>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td>لا توجد بيانات بعد</td>
        <td><?= htmlspecialchars($item['brand_name'] ?? '—') ?></td>
        <td>0</td>
        <td><span class="mini-badge">قريبًا</span></td>
    </tr>
<?php endif; ?>
</tbody> 
            </table>
        </div>
    </div>

    <div class="panel-card">
        <h3 class="panel-title">آخر النشاطات</h3>
        <p class="panel-subtitle">ملخص سريع لحالة لوحة التحكم.</p>

        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-icon">👤</div>
                <div>
                    <p class="activity-title">مرحبًا <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></p>
                    <p class="activity-time">تم تسجيل الدخول بنجاح</p>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-icon">📦</div>
                <div>
                    <p class="activity-title">إحصائيات المنتجات</p>
                    <p class="activity-time">سيتم ربطها بقاعدة البيانات في الخطوات القادمة</p>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-icon">⚙️</div>
                <div>
                    <p class="activity-title">لوحة التحكم جاهزة</p>
                    <p class="activity-time">الخطوة التالية: جلب الإحصائيات الحقيقية</p>
                </div>
            </div>
        </div>
    </div>
</div>