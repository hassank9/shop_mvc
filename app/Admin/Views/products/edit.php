<?php require __DIR__ . '/../partials/header.php'; ?>

<div class="container py-4">
    <h2 class="mb-4">تعديل المنتج</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/admin/products/update/<?= (int)$product['id']; ?>" method="post" enctype="multipart/form-data">
                <?php require __DIR__ . '/_form.php'; ?>

                <?php if (!empty($images)): ?>
                    <hr>
                    <h5 class="mb-3">الصور الحالية</h5>
                    <div class="row">
                        <?php foreach ($images as $img): ?>
                            <div class="col-md-3 mb-3">
                                <div class="border rounded p-2 text-center">
                                    <img src="/uploads/products/<?= htmlspecialchars($img['file_name']); ?>" class="img-fluid mb-2" style="height:150px;object-fit:cover;">
                                    <div>
                                        <?php if ((int)$img['is_main'] === 1): ?>
                                            <span class="badge bg-success">الصورة الرئيسية</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">صورة فرعية</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                    <a href="/admin/products" class="btn btn-secondary">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>