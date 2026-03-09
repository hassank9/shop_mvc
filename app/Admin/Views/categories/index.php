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

    .categories-table-wrap{
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:22px;
        overflow:hidden;
    }

    .categories-table{
        width:100%;
        border-collapse:collapse;
    }

    .categories-table th,
    .categories-table td{
        padding:16px 14px;
        text-align:right;
        border-bottom:1px solid #eef1f5;
        font-size:14px;
        vertical-align:middle;
    }

    .categories-table th{
        background:#fafbfc;
        color:#98a2b3;
        font-size:12px;
        font-weight:800;
    }

    .categories-table tr:last-child td{
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

    .category-modal-overlay{
        position:fixed;
        inset:0;
        background:rgba(15,23,42,.45);
        display:none;
        align-items:center;
        justify-content:center;
        padding:20px;
        z-index:2000;
    }

    .category-modal-overlay.show{
        display:flex;
    }

    .category-modal-box{
        width:min(520px, 100%);
        background:#fff;
        border-radius:24px;
        box-shadow:0 20px 60px rgba(15,23,42,.18);
        border:1px solid #eef1f5;
        overflow:hidden;
    }

    .category-modal-header{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:16px;
        padding:20px 22px;
        border-bottom:1px solid #eef1f5;
    }

    .category-modal-title{
        margin:0 0 6px;
        font-size:22px;
        font-weight:800;
        color:#111827;
    }

    .category-modal-subtitle{
        margin:0;
        color:#7b8595;
        font-size:14px;
    }

    .category-modal-close{
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

    .category-modal-close:hover{
        background:#ffe9e9;
        color:#dc3545;
    }

    .category-modal-body{
        padding:22px;
    }

    @media (max-width: 991.98px){
        .categories-table-wrap{
            overflow:auto;
        }

        .categories-table{
            min-width:700px;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">الأصناف</h1>
        <p class="page-subtitle">إدارة الأصناف: عرض، إضافة، تعديل، وحذف.</p>
    </div>
</div>

<div class="section-card">
    <div class="toolbar">
        <div class="toolbar-actions">
            <button type="button" class="primary-btn" id="openAddCategoryModal">إضافة صنف جديد</button>
        </div>

        <input type="text" class="search-input" placeholder="ابحث عن صنف...">
    </div>

    <div class="categories-table-wrap">
        <table class="categories-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الصنف</th>
                    <th>تاريخ الإنشاء</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= (int)($category['id'] ?? 0) ?></td>
                        <td><?= htmlspecialchars($category['name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($category['created_at'] ?? '') ?></td>
                        <td>
                            <div class="table-actions">
                                <button
                                    type="button"
                                    class="action-btn edit js-edit-category-btn"
                                    data-category-id="<?= (int)($category['id'] ?? 0) ?>">
                                    تعديل
                                </button>

                                <button
                                    type="button"
                                    class="action-btn delete js-delete-category-btn"
                                    data-category-id="<?= (int)($category['id'] ?? 0) ?>"
                                    data-category-name="<?= htmlspecialchars($category['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">لا توجد أصناف حاليًا</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="category-modal-overlay" id="categoryModalOverlay">
    <div class="category-modal-box">
        <div class="category-modal-header">
            <div>
                <h3 class="category-modal-title" id="categoryModalTitle">إضافة صنف جديد</h3>
                <p class="category-modal-subtitle" id="categoryModalSubtitle">أدخل اسم الصنف ثم احفظ</p>
            </div>

            <button type="button" class="category-modal-close" id="categoryModalClose">×</button>
        </div>

        <div class="category-modal-body">
            <input type="hidden" id="categoryIdInput" value="">

            <div class="mb-3">
                <label class="form-label">اسم الصنف</label>
                <input type="text" class="form-control" id="categoryNameInput" placeholder="مثال: إلكترونيات">
            </div>

            <div id="categoryModalMessage" class="mb-3"></div>

            <div class="d-flex justify-content-end gap-2 flex-wrap">
                <button type="button" class="action-btn" id="categoryModalCancel">إلغاء</button>
                <button type="button" class="primary-btn" id="saveCategoryBtn">حفظ الصنف</button>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalOverlay = document.getElementById('categoryModalOverlay');
    const openBtn = document.getElementById('openAddCategoryModal');
    const closeBtn = document.getElementById('categoryModalClose');
    const cancelBtn = document.getElementById('categoryModalCancel');
    const saveBtn = document.getElementById('saveCategoryBtn');
    const nameInput = document.getElementById('categoryNameInput');
    const messageBox = document.getElementById('categoryModalMessage');
    const modalTitle = document.getElementById('categoryModalTitle');
    const modalSubtitle = document.getElementById('categoryModalSubtitle');
    const categoryIdInput = document.getElementById('categoryIdInput');
    const editButtons = document.querySelectorAll('.js-edit-category-btn');
    const deleteButtons = document.querySelectorAll('.js-delete-category-btn');

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
        categoryIdInput.value = '';
        modalTitle.textContent = 'إضافة صنف جديد';
        modalSubtitle.textContent = 'أدخل اسم الصنف ثم احفظ';
        saveBtn.textContent = 'حفظ الصنف';
    }

    function setEditMode(category) {
        categoryIdInput.value = category.id || '';
        nameInput.value = category.name || '';
        modalTitle.textContent = 'تعديل الصنف';
        modalSubtitle.textContent = 'عدّل اسم الصنف ثم احفظ التغييرات';
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
            const categoryId = this.dataset.categoryId || '';

            messageBox.innerHTML = '';
            modalOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';

            modalTitle.textContent = 'جاري تحميل بيانات الصنف...';
            modalSubtitle.textContent = 'يرجى الانتظار';
            nameInput.value = '';
            categoryIdInput.value = '';

            try {
                const response = await fetch(`${window.APP_BASE_PATH}/admin/api/categories/show?id=${encodeURIComponent(categoryId)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'تعذر تحميل بيانات الصنف');
                }

                setEditMode(result.category || {});
                setTimeout(() => nameInput.focus(), 100);
            } catch (error) {
                messageBox.innerHTML = `
                    <div class="alert alert-danger mb-0">
                        ${escapeHtml(error.message || 'حدث خطأ أثناء تحميل بيانات الصنف')}
                    </div>
                `;
                modalTitle.textContent = 'تعديل الصنف';
                modalSubtitle.textContent = 'تعذر تحميل البيانات';
            }
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', async function () {
            const categoryId = this.dataset.categoryId || '';
            const categoryName = this.dataset.categoryName || '';

            const confirmed = confirm(`هل أنت متأكد من حذف الصنف: ${categoryName} ؟`);
            if (!confirmed) return;

            this.disabled = true;
            const originalText = this.textContent;
            this.textContent = 'جاري الحذف...';

            try {
                const formData = new URLSearchParams();
                formData.append('id', categoryId);

                const response = await fetch(`${window.APP_BASE_PATH}/admin/api/categories/delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData.toString()
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'تعذر حذف الصنف');
                }

                window.location.reload();
            } catch (error) {
                alert(error.message || 'حدث خطأ أثناء حذف الصنف');
                this.disabled = false;
                this.textContent = originalText;
            }
        });
    });

    if (saveBtn) {
        saveBtn.addEventListener('click', async function () {
            const id = (categoryIdInput.value || '').trim();
            const name = (nameInput.value || '').trim();

            messageBox.innerHTML = '';

            if (!name) {
                messageBox.innerHTML = `
                    <div class="alert alert-danger mb-0">يرجى إدخال اسم الصنف</div>
                `;
                nameInput.focus();
                return;
            }

            const isEditMode = id !== '';
            const endpoint = isEditMode
                ? `${window.APP_BASE_PATH}/admin/api/categories/update`
                : `${window.APP_BASE_PATH}/admin/api/categories/store`;

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
                    throw new Error(result.message || (isEditMode ? 'تعذر تعديل الصنف' : 'تعذر حفظ الصنف'));
                }

                messageBox.innerHTML = `
                    <div class="alert alert-success mb-0">
                        ${escapeHtml(result.message || (isEditMode ? 'تم تعديل الصنف بنجاح' : 'تم إضافة الصنف بنجاح'))}
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
                this.textContent = categoryIdInput.value ? 'حفظ التعديل' : 'حفظ الصنف';
            }
        });
    }
});
</script>