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

    .users-modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.45);
    display:none;
    align-items:center;
    justify-content:center;
    padding:20px;
    z-index:2500;
}

.users-modal-overlay.show{
    display:flex;
}

.users-modal-box{
    width:min(720px, 100%);
    max-height:90vh;
    background:#fff;
    border-radius:24px;
    box-shadow:0 20px 60px rgba(15,23,42,.18);
    border:1px solid #eef1f5;
    display:flex;
    flex-direction:column;
    overflow:hidden;
}

.users-modal-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    padding:20px 22px;
    border-bottom:1px solid #eef1f5;
}

.users-modal-title{
    margin:0 0 6px;
    font-size:22px;
    font-weight:800;
    color:#111827;
}

.users-modal-subtitle{
    margin:0;
    color:#7b8595;
    font-size:14px;
}

.users-modal-close{
    width:42px;
    height:42px;
    border:none;
    border-radius:14px;
    background:#f4f6fa;
    color:#111827;
    font-size:26px;
    line-height:1;
    cursor:pointer;
}

.users-modal-close:hover{
    background:#ffe9e9;
    color:#dc3545;
}

.users-modal-body{
    padding:22px;
    overflow-y:auto;
}

.users-modal-grid{
    display:grid;
    grid-template-columns:repeat(2, minmax(0, 1fr));
    gap:16px;
}

.users-modal-grid .full{
    grid-column:1 / -1;
}

.users-modal-label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:700;
    color:#111827;
}

.users-modal-value{
    min-height:48px;
    padding:12px 14px;
    border:1px solid #e8edf3;
    border-radius:14px;
    background:#fafbfc;
    color:#1f2937;
    display:flex;
    align-items:center;
}

.users-modal-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
    flex-wrap:wrap;
    margin-top:22px;
}

@media (max-width: 767.98px){
    .users-modal-grid{
        grid-template-columns:1fr;
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
<?php if (!empty($users)): ?>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= (int)($user['id'] ?? 0) ?></td>
            <td>
                    <?= htmlspecialchars($user['full_name'] ?? '') ?>
                
            </td>
            <td><?= htmlspecialchars($user['phone'] ?? '—') ?></td>
            <td><?= htmlspecialchars($user['address'] ?? '—') ?></td>
            <td><span class="badge-soft badge-user">مستخدم</span></td>
            <td>
<div class="table-actions">
    <button
        type="button"
        class="action-btn view js-view-user-btn"
        data-user-type="user"
        data-user-id="<?= (int)($user['id'] ?? 0) ?>"
        data-user-name="<?= htmlspecialchars($user['full_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        data-user-phone="<?= htmlspecialchars($user['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        data-user-address="<?= htmlspecialchars($user['address'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        عرض
    </button>

    <button
        type="button"
        class="action-btn edit js-edit-user-btn"
        data-user-type="user"
        data-user-id="<?= (int)($user['id'] ?? 0) ?>"
        data-user-name="<?= htmlspecialchars($user['full_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        data-user-phone="<?= htmlspecialchars($user['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        data-user-address="<?= htmlspecialchars($user['address'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        تعديل
    </button>

    <button
        type="button"
        class="action-btn delete js-delete-user-btn"
        data-user-type="user"
        data-user-id="<?= (int)($user['id'] ?? 0) ?>"
        data-user-name="<?= htmlspecialchars($user['full_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        حذف
    </button>
</div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="text-center">لا يوجد مستخدمون حاليًا</td>
    </tr>
<?php endif; ?>
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
<?php if (!empty($admins)): ?>
    <?php foreach ($admins as $admin): ?>
        <tr>
            <td><?= (int)($admin['id'] ?? 0) ?></td>
            <td>
                <div class="user-name"><?= htmlspecialchars($admin['full_name'] ?? $admin['username'] ?? '') ?></div>
                <div class="user-meta"><?= htmlspecialchars($admin['username'] ?? '') ?></div>
            </td>
            <td><?= htmlspecialchars($admin['username'] ?? '') ?></td>
            <td><span class="badge-soft badge-admin"><?= htmlspecialchars($admin['role'] ?? 'Admin') ?></span></td>
            <td>
<div class="table-actions">
    <button
        type="button"
        class="action-btn view js-view-user-btn"
        data-user-type="admin"
        data-user-id="<?= (int)($admin['id'] ?? 0) ?>"
        data-user-name="<?= htmlspecialchars($admin['full_name'] ?? $admin['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        data-user-username="<?= htmlspecialchars($admin['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        data-user-role="<?= htmlspecialchars($admin['role'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?>">
        عرض
    </button>

    <button
        type="button"
        class="action-btn edit js-edit-user-btn"
        data-user-type="admin"
        data-user-id="<?= (int)($admin['id'] ?? 0) ?>"
        data-user-name="<?= htmlspecialchars($admin['full_name'] ?? $admin['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        data-user-username="<?= htmlspecialchars($admin['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        data-user-role="<?= htmlspecialchars($admin['role'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?>">
        تعديل
    </button>

    <button
        type="button"
        class="action-btn delete js-delete-user-btn"
        data-user-type="admin"
        data-user-id="<?= (int)($admin['id'] ?? 0) ?>"
        data-user-name="<?= htmlspecialchars($admin['full_name'] ?? $admin['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        حذف
    </button>
</div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="text-center">لا يوجد أدمنية حاليًا</td>
    </tr>
<?php endif; ?>
</tbody>
            </table>
        </div>
    </div>
</div>


<div class="users-modal-overlay" id="usersModalOverlay">
    <div class="users-modal-box">
        <div class="users-modal-header">
            <div>
                <h3 class="users-modal-title" id="usersModalTitle">تفاصيل المستخدم</h3>
                <p class="users-modal-subtitle" id="usersModalSubtitle">عرض بيانات المستخدم</p>
            </div>

            <button type="button" class="users-modal-close" id="usersModalClose">×</button>
        </div>

        <div class="users-modal-body">
            <input type="hidden" id="modalUserId" value="">
            <input type="hidden" id="modalUserType" value="">

            <div id="usersModalMessage" class="mb-3"></div>

<div class="users-modal-grid">
    <div>
        <label class="users-modal-label">الاسم</label>
        <input type="text" class="form-control" id="modalFieldName" value="">
    </div>

    <div>
        <label class="users-modal-label">النوع</label>
        <div class="users-modal-value" id="modalFieldType">—</div>
    </div>

    <div id="modalPhoneWrap">
        <label class="users-modal-label">الهاتف</label>
        <input type="text" class="form-control" id="modalFieldPhone" value="">
    </div>

    <div id="modalUsernameWrap" style="display:none;">
        <label class="users-modal-label">اسم المستخدم</label>
        <input type="text" class="form-control" id="modalFieldUsername" value="">
    </div>

    <div id="modalRoleWrap" style="display:none;">
        <label class="users-modal-label">الدور</label>
        <input type="text" class="form-control" id="modalFieldRole" value="">
    </div>

    <div class="full" id="modalAddressWrap">
        <label class="users-modal-label">العنوان</label>
        <input type="text" class="form-control" id="modalFieldAddress" value="">
    </div>
</div>

<div class="users-modal-actions">
    <button type="button" class="action-btn" id="usersModalCancel">إلغاء</button>
    <button type="button" class="action-btn edit" id="usersModalSave" style="display:none;">حفظ التعديلات</button>
</div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalOverlay = document.getElementById('usersModalOverlay');
    const modalClose = document.getElementById('usersModalClose');
    const modalCancel = document.getElementById('usersModalCancel');

    const modalTitle = document.getElementById('usersModalTitle');
    const modalSubtitle = document.getElementById('usersModalSubtitle');

    const modalUserId = document.getElementById('modalUserId');
    const modalUserType = document.getElementById('modalUserType');

    const modalFieldName = document.getElementById('modalFieldName');
    const modalFieldType = document.getElementById('modalFieldType');
    const modalFieldPhone = document.getElementById('modalFieldPhone');
    const modalFieldUsername = document.getElementById('modalFieldUsername');
    const modalFieldRole = document.getElementById('modalFieldRole');
    const modalFieldAddress = document.getElementById('modalFieldAddress');

    const modalPhoneWrap = document.getElementById('modalPhoneWrap');
    const modalUsernameWrap = document.getElementById('modalUsernameWrap');
    const modalRoleWrap = document.getElementById('modalRoleWrap');
    const modalAddressWrap = document.getElementById('modalAddressWrap');

    const viewButtons = document.querySelectorAll('.js-view-user-btn');
    const editButtons = document.querySelectorAll('.js-edit-user-btn');
    const deleteButtons = document.querySelectorAll('.js-delete-user-btn');
    const usersModalSave = document.getElementById('usersModalSave');

    const usersModalMessage = document.getElementById('usersModalMessage');
    

    function openModal() {
        modalOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modalOverlay.classList.remove('show');
        document.body.style.overflow = '';
    }

function fillModalFromButton(button, mode = 'view') {
    const type = button.dataset.userType || '';
    const id = button.dataset.userId || '';
    const name = button.dataset.userName || '';
    const phone = button.dataset.userPhone || '';
    const address = button.dataset.userAddress || '';
    const username = button.dataset.userUsername || '';
    const role = button.dataset.userRole || 'Admin';

    modalUserId.value = id;
    modalUserType.value = type;

    modalFieldName.value = name;
    modalFieldType.textContent = type === 'admin' ? 'أدمن' : 'مستخدم';
    modalFieldPhone.value = phone;
    modalFieldAddress.value = address;
    modalFieldUsername.value = username;
    modalFieldRole.value = role;

    const isEdit = mode === 'edit';

    modalFieldName.readOnly = !isEdit;
    modalFieldPhone.readOnly = !isEdit;
    modalFieldAddress.readOnly = !isEdit;
    modalFieldUsername.readOnly = !isEdit;
    modalFieldRole.readOnly = !isEdit;

    usersModalSave.style.display = isEdit ? '' : 'none';

    if (type === 'admin') {
        modalPhoneWrap.style.display = 'none';
        modalAddressWrap.style.display = 'none';
        modalUsernameWrap.style.display = '';
        modalRoleWrap.style.display = '';

        if (isEdit) {
            modalTitle.textContent = 'تعديل الأدمن';
            modalSubtitle.textContent = 'عدّل بيانات الأدمن ثم احفظ التغييرات';
        } else {
            modalTitle.textContent = 'تفاصيل الأدمن';
            modalSubtitle.textContent = 'عرض بيانات الأدمن';
        }
    } else {
        modalPhoneWrap.style.display = '';
        modalAddressWrap.style.display = '';
        modalUsernameWrap.style.display = 'none';
        modalRoleWrap.style.display = 'none';

        if (isEdit) {
            modalTitle.textContent = 'تعديل المستخدم';
            modalSubtitle.textContent = 'عدّل بيانات المستخدم ثم احفظ التغييرات';
        } else {
            modalTitle.textContent = 'تفاصيل المستخدم';
            modalSubtitle.textContent = 'عرض بيانات المستخدم';
        }
    }
}

viewButtons.forEach(button => {
    button.addEventListener('click', function () {
        fillModalFromButton(this, 'view');
        openModal();
    });
});

editButtons.forEach(button => {
    button.addEventListener('click', function () {
        fillModalFromButton(this, 'edit');
        openModal();
    });
});

deleteButtons.forEach(button => {
    button.addEventListener('click', async function () {
        const id = this.dataset.userId || '';
        const type = this.dataset.userType || '';
        const name = this.dataset.userName || '';

        const confirmed = confirm(`هل أنت متأكد من حذف ${type === 'admin' ? 'الأدمن' : 'المستخدم'}: ${name} ؟`);
        if (!confirmed) {
            return;
        }

        this.disabled = true;
        const originalText = this.textContent;
        this.textContent = 'جاري الحذف...';

        try {
            const formData = new URLSearchParams();
            formData.append('id', id);
            formData.append('type', type);

            const response = await fetch('/shop_mvc/public/admin/api/users/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData.toString()
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'تعذر الحذف');
            }

            alert(result.message || 'تم الحذف بنجاح');
            window.location.reload();
        } catch (error) {
            alert(error.message || 'حدث خطأ أثناء الحذف');
            this.disabled = false;
            this.textContent = originalText;
        }
    });
});

        if (usersModalSave) {
    usersModalSave.addEventListener('click', async function () {
        const id = (modalUserId.value || '').trim();
        const type = (modalUserType.value || '').trim();

        const payload = {
            id: id,
            type: type,
            full_name: (modalFieldName.value || '').trim(),
            phone: (modalFieldPhone.value || '').trim(),
            address: (modalFieldAddress.value || '').trim(),
            username: (modalFieldUsername.value || '').trim(),
            role: (modalFieldRole.value || '').trim()
        };

        usersModalMessage.innerHTML = '';

        if (!payload.id || !payload.type || !payload.full_name) {
            usersModalMessage.innerHTML = `
                <div class="alert alert-danger mb-0">
                    يرجى تعبئة البيانات المطلوبة
                </div>
            `;
            return;
        }

        if (payload.type === 'user' && (!payload.phone || !payload.address)) {
            usersModalMessage.innerHTML = `
                <div class="alert alert-danger mb-0">
                    يرجى تعبئة الهاتف والعنوان للمستخدم
                </div>
            `;
            return;
        }

        if (payload.type === 'admin' && (!payload.username || !payload.role)) {
            usersModalMessage.innerHTML = `
                <div class="alert alert-danger mb-0">
                    يرجى تعبئة اسم المستخدم والدور للأدمن
                </div>
            `;
            return;
        }

        this.disabled = true;
        this.textContent = 'جاري الحفظ...';

        try {
            const formData = new URLSearchParams();
            formData.append('id', payload.id);
            formData.append('type', payload.type);
            formData.append('full_name', payload.full_name);
            formData.append('phone', payload.phone);
            formData.append('address', payload.address);
            formData.append('username', payload.username);
            formData.append('role', payload.role);

            const response = await fetch('/shop_mvc/public/admin/api/users/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData.toString()
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'تعذر حفظ التعديلات');
            }

            usersModalMessage.innerHTML = `
                <div class="alert alert-success mb-0">
                    ${result.message || 'تم حفظ التعديلات بنجاح'}
                </div>
            `;

            setTimeout(() => window.location.reload(), 700);
        } catch (error) {
            usersModalMessage.innerHTML = `
                <div class="alert alert-danger mb-0">
                    ${error.message || 'حدث خطأ أثناء الحفظ'}
                </div>
            `;
        } finally {
            this.disabled = false;
            this.textContent = 'حفظ التعديلات';
        }
    });
}




    if (modalClose) modalClose.addEventListener('click', closeModal);
    if (modalCancel) modalCancel.addEventListener('click', closeModal);

    modalOverlay.addEventListener('click', function (e) {
        if (e.target === modalOverlay) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
});

</script>


