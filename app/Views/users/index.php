<style>
    .page-header{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:24px;
    }

    .page-title{
        font-size:24px;
        font-weight:800;
        margin:0 0 6px;
        color:#111827;
    }

    .page-subtitle{
        margin:0;
        color:#7b8595;
        font-size:14px;
    }

    .users-grid{
        display:grid;
        grid-template-columns:1fr;
        gap:22px;
    }

    .section-card{
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:22px;
        padding:20px;
        box-shadow:0 10px 25px rgba(15,23,42,.04);
    }

    .section-title{
        font-size:20px;
        font-weight:800;
        margin:0 0 6px;
        color:#111827;
    }

    .section-subtitle{
        margin:0 0 18px;
        color:#7b8595;
        font-size:14px;
    }

    .users-table-wrap{
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:18px;
        overflow:hidden;
    }

    .users-table{
        width:100%;
        border-collapse:collapse;
    }

    .users-table th,
    .users-table td{
        padding:16px 14px;
        text-align:right;
        border-bottom:1px solid #eef1f5;
        font-size:14px;
        vertical-align:middle;
    }

    .users-table th{
        background:#fafbfc;
        color:#98a2b3;
        font-size:12px;
        font-weight:800;
    }

    .users-table tr:last-child td{
        border-bottom:none;
    }

    .user-name{
        font-weight:800;
        color:#111827;
        margin-bottom:4px;
    }

    .user-meta{
        color:#7b8595;
        font-size:12px;
    }

    .table-actions{
        display:flex;
        gap:8px;
        flex-wrap:wrap;
    }

    .action-btn{
        border:none;
        background:#f4f6fa;
        color:#1f2937;
        border-radius:12px;
        padding:8px 12px;
        font-size:13px;
        font-weight:700;
        cursor:pointer;
    }

    .action-btn.edit{
        background:#fff3e8;
        color:#ff6a00;
    }

    .action-btn.delete{
        background:#ffe8e8;
        color:#dc3545;
    }

    .action-btn.view{
        background:#eef4ff;
        color:#2563eb;
    }

    .badge-soft{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:6px 10px;
        border-radius:999px;
        font-size:12px;
        font-weight:800;
    }

    .badge-user{
        background:#eef4ff;
        color:#2563eb;
    }

    .badge-admin{
        background:#fff3e8;
        color:#ff6a00;
    }

    @media (max-width: 991.98px){
        .users-table-wrap{
            overflow:auto;
        }

        .users-table{
            min-width:850px;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">المستخدمون</h1>
        <p class="page-subtitle">إدارة المستخدمين العاديين والأدمنية من لوحة التحكم.</p>
    </div>
</div>

<div class="users-grid">
    <div class="section-card">
        <h2 class="section-title">المستخدمون العاديون</h2>
        <p class="section-subtitle">عرض وإدارة حسابات العملاء المسجلين في الموقع.</p>

        <div class="users-table-wrap">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الهاتف</th>
                        <th>العنوان</th>
                        <th>النوع</th>
                        <th>إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <div class="user-name">حسن كريم</div>
                            <div class="user-meta">user@example.com</div>
                        </td>
                        <td>07700000000</td>
                        <td>البصرة</td>
                        <td><span class="badge-soft badge-user">مستخدم</span></td>
                        <td>
                            <div class="table-actions">
                                <button type="button" class="action-btn view">عرض</button>
                                <button type="button" class="action-btn edit">تعديل</button>
                                <button type="button" class="action-btn delete">حذف</button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>
                            <div class="user-name">أحمد علي</div>
                            <div class="user-meta">ahmed@example.com</div>
                        </td>
                        <td>07800000000</td>
                        <td>بغداد</td>
                        <td><span class="badge-soft badge-user">مستخدم</span></td>
                        <td>
                            <div class="table-actions">
                                <button type="button" class="action-btn view">عرض</button>
                                <button type="button" class="action-btn edit">تعديل</button>
                                <button type="button" class="action-btn delete">حذف</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="section-card">
        <h2 class="section-title">الأدمنية</h2>
        <p class="section-subtitle">عرض وإدارة حسابات المشرفين ومديري لوحة التحكم.</p>

        <div class="users-table-wrap">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>اسم المستخدم</th>
                        <th>الدور</th>
                        <th>إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <div class="user-name">Super Admin</div>
                            <div class="user-meta">super_admin</div>
                        </td>
                        <td>super_admin</td>
                        <td><span class="badge-soft badge-admin">Admin</span></td>
                        <td>
                            <div class="table-actions">
                                <button type="button" class="action-btn view">عرض</button>
                                <button type="button" class="action-btn edit">تعديل</button>
                                <button type="button" class="action-btn delete">حذف</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>