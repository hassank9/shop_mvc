<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="container py-4">
    <h2 class="mb-4">إضافة منتج جديد</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/admin/products/store" method="post" enctype="multipart/form-data">
                <?php require __DIR__ . '/_form.php'; ?>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">حفظ المنتج</button>
                    <a href="/admin/products" class="btn btn-secondary">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>