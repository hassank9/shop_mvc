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

    .section-card{
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:22px;
        padding:20px;
        box-shadow:0 10px 25px rgba(15,23,42,.04);
    }

    .toolbar{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:18px;
    }

    .toolbar-actions{
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    }

    .search-input{
        min-width:260px;
        background:#fff;
        border:1px solid #e8edf3;
        border-radius:14px;
        padding:10px 14px;
        font-size:14px;
        outline:none;
    }

    .primary-btn{
        border:none;
        background:#ff6a00;
        color:#fff;
        border-radius:14px;
        padding:10px 16px;
        font-size:14px;
        font-weight:700;
        cursor:pointer;
    }

    .primary-btn:hover{
        background:#e55f00;
    }

    .brands-table-wrap{
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:22px;
        overflow:hidden;
    }

    .brands-table{
        width:100%;
        border-collapse:collapse;
    }

    .brands-table th,
    .brands-table td{
        padding:16px 14px;
        text-align:right;
        border-bottom:1px solid #eef1f5;
        font-size:14px;
        vertical-align:middle;
    }

    .brands-table th{
        background:#fafbfc;
        color:#98a2b3;
        font-size:12px;
        font-weight:800;
    }

    .brands-table tr:last-child td{
        border-bottom:none;
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

    @media (max-width: 991.98px){
        .brands-table-wrap{
            overflow:auto;
        }

        .brands-table{
            min-width:700px;
        }
    }


    .brand-modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.45);
    display:none;
    align-items:center;
    justify-content:center;
    padding:20px;
    z-index:2000;
}

.brand-modal-overlay.show{
    display:flex;
}

.brand-modal-box{
    width:min(520px, 100%);
    background:#fff;
    border-radius:24px;
    box-shadow:0 20px 60px rgba(15,23,42,.18);
    border:1px solid #eef1f5;
    overflow:hidden;
}

.brand-modal-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    padding:20px 22px;
    border-bottom:1px solid #eef1f5;
}

.brand-modal-title{
    margin:0 0 6px;
    font-size:22px;
    font-weight:800;
    color:#111827;
}

.brand-modal-subtitle{
    margin:0;
    color:#7b8595;
    font-size:14px;
}

.brand-modal-close{
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

.brand-modal-close:hover{
    background:#ffe9e9;
    color:#dc3545;
}

.brand-modal-body{
    padding:22px;
}
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">البراندات</h1>
        <p class="page-subtitle">إدارة البراندات: عرض، إضافة، تعديل، وحذف.</p>
    </div>
</div>

<div class="section-card">
    <div class="toolbar">
        <div class="toolbar-actions">
            <button type="button" class="primary-btn" id="openAddBrandModal">إضافة براند جديد</button>
        </div>

        <input type="text" class="search-input" placeholder="ابحث عن براند...">
    </div>

    <div class="brands-table-wrap">
        <table class="brands-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم البراند</th>
                    <th>تاريخ الإنشاء</th>
                    <th>إجراء</th>
                </tr>
            </thead>
<tbody>
<?php if (!empty($brands)): ?>
    <?php foreach ($brands as $brand): ?>
        <tr>
            <td><?= (int)($brand['id'] ?? 0) ?></td>
            <td><?= htmlspecialchars($brand['name'] ?? '') ?></td>
            <td><?= htmlspecialchars($brand['created_at'] ?? '') ?></td>
            <td>
<div class="table-actions">
    <button
        type="button"
        class="action-btn edit js-edit-brand-btn"
        data-brand-id="<?= (int)($brand['id'] ?? 0) ?>">
        تعديل
    </button>

    <button
        type="button"
        class="action-btn delete js-delete-brand-btn"
        data-brand-id="<?= (int)($brand['id'] ?? 0) ?>"
        data-brand-name="<?= htmlspecialchars($brand['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        حذف
    </button>
</div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="4" class="text-center">لا توجد براندات حاليًا</td>
    </tr>
<?php endif; ?>
</tbody>
        </table>


        <div class="brand-modal-overlay" id="brandModalOverlay">
    <div class="brand-modal-box">
        <div class="brand-modal-header">
            <div>
                <h3 class="brand-modal-title" id="brandModalTitle">إضافة براند جديد</h3>
                <p class="brand-modal-subtitle" id="brandModalSubtitle">أدخل اسم البراند ثم احفظ</p>
            </div>

            <button type="button" class="brand-modal-close" id="brandModalClose">×</button>
        </div>

        <div class="brand-modal-body">
            <input type="hidden" id="brandIdInput" value="">

            <div class="mb-3">
                <label class="form-label">اسم البراند</label>
                <input type="text" class="form-control" id="brandNameInput" placeholder="مثال: Nike">
            </div>

            <div id="brandModalMessage" class="mb-3"></div>

            <div class="d-flex justify-content-end gap-2 flex-wrap">
                <button type="button" class="action-btn" id="brandModalCancel">إلغاء</button>
                <button type="button" class="primary-btn" id="saveBrandBtn">حفظ البراند</button>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalOverlay = document.getElementById('brandModalOverlay');
    const openBtn = document.getElementById('openAddBrandModal');
    const closeBtn = document.getElementById('brandModalClose');
    const cancelBtn = document.getElementById('brandModalCancel');
    const saveBtn = document.getElementById('saveBrandBtn');
    const nameInput = document.getElementById('brandNameInput');
    const messageBox = document.getElementById('brandModalMessage');
    const modalTitle = document.getElementById('brandModalTitle');
    const modalSubtitle = document.getElementById('brandModalSubtitle');
    const brandIdInput = document.getElementById('brandIdInput');
    const editButtons = document.querySelectorAll('.js-edit-brand-btn');
    const deleteButtons = document.querySelectorAll('.js-delete-brand-btn');

function openModal() {
    modalOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';
    messageBox.innerHTML = '';
    nameInput.value = '';
    setAddMode();
    setTimeout(() => nameInput.focus(), 100);
}

    function closeModal() {
        modalOverlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function setAddMode() {
    brandIdInput.value = '';
    modalTitle.textContent = 'إضافة براند جديد';
    modalSubtitle.textContent = 'أدخل اسم البراند ثم احفظ';
    saveBtn.textContent = 'حفظ البراند';
}

function setEditMode(brand) {
    brandIdInput.value = brand.id || '';
    nameInput.value = brand.name || '';
    modalTitle.textContent = 'تعديل البراند';
    modalSubtitle.textContent = 'عدّل اسم البراند ثم احفظ التغييرات';
    saveBtn.textContent = 'حفظ التعديل';
}

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

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


    editButtons.forEach(button => {
    button.addEventListener('click', async function () {
        const brandId = this.dataset.brandId || '';

        messageBox.innerHTML = '';
        modalOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';

        modalTitle.textContent = 'جاري تحميل بيانات البراند...';
        modalSubtitle.textContent = 'يرجى الانتظار';
        nameInput.value = '';
        brandIdInput.value = '';

        try {
            const response = await fetch(`/shop_mvc/public/admin/api/brands/show?id=${encodeURIComponent(brandId)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'تعذر تحميل بيانات البراند');
            }

            setEditMode(result.brand || {});
            setTimeout(() => nameInput.focus(), 100);
        } catch (error) {
            messageBox.innerHTML = `
                <div class="alert alert-danger mb-0">
                    ${escapeHtml(error.message || 'حدث خطأ أثناء تحميل بيانات البراند')}
                </div>
            `;
            modalTitle.textContent = 'تعديل البراند';
            modalSubtitle.textContent = 'تعذر تحميل البيانات';
        }
    });
});

deleteButtons.forEach(button => {
    button.addEventListener('click', async function () {
        const brandId = this.dataset.brandId || '';
        const brandName = this.dataset.brandName || '';

        const confirmed = confirm(`هل أنت متأكد من حذف البراند: ${brandName} ؟`);
        if (!confirmed) {
            return;
        }

        this.disabled = true;
        const originalText = this.textContent;
        this.textContent = 'جاري الحذف...';

        try {
            const formData = new URLSearchParams();
            formData.append('id', brandId);

            const response = await fetch('/shop_mvc/public/admin/api/brands/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData.toString()
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'تعذر حذف البراند');
            }

            window.location.reload();
        } catch (error) {
            alert(error.message || 'حدث خطأ أثناء حذف البراند');
            this.disabled = false;
            this.textContent = originalText;
        }
    });
});

if (saveBtn) {
    saveBtn.addEventListener('click', async function () {
        const id = (brandIdInput.value || '').trim();
        const name = (nameInput.value || '').trim();

        messageBox.innerHTML = '';

        if (!name) {
            messageBox.innerHTML = `
                <div class="alert alert-danger mb-0">يرجى إدخال اسم البراند</div>
            `;
            nameInput.focus();
            return;
        }

        const isEditMode = id !== '';
        const endpoint = isEditMode
            ? '/shop_mvc/public/admin/api/brands/update'
            : '/shop_mvc/public/admin/api/brands/store';

        this.disabled = true;
        this.textContent = isEditMode ? 'جاري حفظ التعديل...' : 'جاري الحفظ...';

        try {
            const formData = new URLSearchParams();

            if (isEditMode) {
                formData.append('id', id);
            }

            formData.append('name', name);

            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData.toString()
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || (isEditMode ? 'تعذر تعديل البراند' : 'تعذر حفظ البراند'));
            }

            messageBox.innerHTML = `
                <div class="alert alert-success mb-0">
                    ${escapeHtml(result.message || (isEditMode ? 'تم تعديل البراند بنجاح' : 'تم إضافة البراند بنجاح'))}
                </div>
            `;

            setTimeout(() => window.location.reload(), 700);
        } catch (error) {
            messageBox.innerHTML = `
                <div class="alert alert-danger mb-0">
                    ${escapeHtml(error.message || 'حدث خطأ أثناء الحفظ')}
                </div>
            `;
        } finally {
            this.disabled = false;
            this.textContent = brandIdInput.value ? 'حفظ التعديل' : 'حفظ البراند';
        }
    });
}
});
</script>
    </div>
</div>