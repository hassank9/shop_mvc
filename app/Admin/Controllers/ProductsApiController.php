<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Product;
use PDO;
use PDOException;
use Throwable;

class ProductsApiController
{
    protected ?PDO $db = null;

    public function __construct()
    {
        $this->db = $this->createAdminConnection();
    }

    private function createAdminConnection(): PDO
    {
        $host = 'localhost';
        $dbname = 'firstclass_shop';
        $username = 'root';
        $password = '';

        try {
            return new PDO(
                "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => false,
                'message' => 'Database connection failed',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    private function uploadMainImage(array $file): string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return '';
        }

        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('فشل رفع الصورة');
        }

        $tmpPath = $file['tmp_name'] ?? '';
        if ($tmpPath === '' || !is_uploaded_file($tmpPath)) {
            throw new \RuntimeException('ملف الصورة غير صالح');
        }

        $allowedMimeTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
        ];

        $mimeType = mime_content_type($tmpPath) ?: '';
        if (!isset($allowedMimeTypes[$mimeType])) {
            throw new \RuntimeException('صيغة الصورة غير مدعومة');
        }

        $maxSize = 5 * 1024 * 1024;
        if ((int)($file['size'] ?? 0) > $maxSize) {
            throw new \RuntimeException('حجم الصورة كبير جدًا، الحد الأقصى 5MB');
        }

        $extension = $allowedMimeTypes[$mimeType];
        $fileName = uniqid('product_', true) . '.' . $extension;

        $uploadDir = dirname(__DIR__, 3) . '/public/uploads/products';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
            throw new \RuntimeException('تعذر إنشاء مجلد الصور');
        }

        $destination = $uploadDir . '/' . $fileName;

        if (!move_uploaded_file($tmpPath, $destination)) {
            throw new \RuntimeException('تعذر حفظ الصورة على السيرفر');
        }

        return $fileName;
    }

    public function store(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['admin_id'])) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        try {
                $uploadedImageName = '';
                if (isset($_FILES['main_image'])) {
                    $uploadedImageName = $this->uploadMainImage($_FILES['main_image']);
                }

                $uploadedGalleryImages = [];
                if (isset($_FILES['gallery_images'])) {
                    $uploadedGalleryImages = $this->uploadGalleryImages($_FILES['gallery_images']);
                }

            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'slug' => trim($_POST['slug'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'brand_id' => (int)($_POST['brand_id'] ?? 0),
                'category_id' => (int)($_POST['category_id'] ?? 0),
                'price' => (float)($_POST['price'] ?? 0),
                'cost_price' => (float)($_POST['cost_price'] ?? 0),
                'qty' => (int)($_POST['qty'] ?? 0),
                'rating' => (float)($_POST['rating'] ?? 0),
                'is_active' => (int)($_POST['is_active'] ?? 1),
                'main_image' => $uploadedImageName,
                'gallery_images' => $uploadedGalleryImages,
            ];

            if (
                $data['name'] === '' ||
                $data['slug'] === '' ||
                $data['brand_id'] <= 0 ||
                $data['category_id'] <= 0
            ) {
                http_response_code(422);
                echo json_encode([
                    'success' => false,
                    'message' => 'يرجى تعبئة الحقول المطلوبة بشكل صحيح',
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $productModel = new Product($this->db);
            $created = $productModel->create($data);

            if (!$created) {
                http_response_code(422);
                echo json_encode([
                    'success' => false,
                    'message' => 'تعذر حفظ المنتج',
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            echo json_encode([
                'success' => true,
                'message' => 'تم إضافة المنتج بنجاح',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    public function show(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['admin_id'])) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'رقم المنتج غير صالح',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $productModel = new Product($this->db);
        $product = $productModel->findById($id);

        if (!$product) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'المنتج غير موجود',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode([
            'success' => true,
            'product' => $product,
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function update(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['admin_id'])) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        try {
            $id = (int)($_POST['id'] ?? 0);

            $productModel = new Product($this->db);
            $product = $productModel->findById($id);

            if (!$product) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'المنتج غير موجود',
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

                $uploadedImageName = $product['main_image'] ?? '';
                if (isset($_FILES['main_image']) && (int)($_FILES['main_image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                    $uploadedImageName = $this->uploadMainImage($_FILES['main_image']);
                }

                $uploadedGalleryImages = [];
                if (isset($_FILES['gallery_images'])) {
                    $uploadedGalleryImages = $this->uploadGalleryImages($_FILES['gallery_images']);
                }

            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'slug' => trim($_POST['slug'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'brand_id' => (int)($_POST['brand_id'] ?? 0),
                'category_id' => (int)($_POST['category_id'] ?? 0),
                'price' => (float)($_POST['price'] ?? 0),
                'cost_price' => (float)($_POST['cost_price'] ?? 0),
                'qty' => (int)($_POST['qty'] ?? 0),
                'rating' => (float)($_POST['rating'] ?? 0),
                'is_active' => (int)($_POST['is_active'] ?? 1),
                'main_image' => $uploadedImageName,
                'gallery_images' => $uploadedGalleryImages,
            ];

            if (
                $id <= 0 ||
                $data['name'] === '' ||
                $data['slug'] === '' ||
                $data['brand_id'] <= 0 ||
                $data['category_id'] <= 0
            ) {
                http_response_code(422);
                echo json_encode([
                    'success' => false,
                    'message' => 'البيانات المرسلة غير صالحة',
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $updated = $productModel->update($id, $data);

            if (!$updated) {
                http_response_code(422);
                echo json_encode([
                    'success' => false,
                    'message' => 'تعذر تحديث المنتج',
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            echo json_encode([
                'success' => true,
                'message' => 'تم تعديل المنتج بنجاح',
            ], JSON_UNESCAPED_UNICODE);
            exit;
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }


    private function uploadGalleryImages(array $files): array
{
    $uploaded = [];

    if (
        !isset($files['name']) ||
        !is_array($files['name'])
    ) {
        return $uploaded;
    }

    $count = count($files['name']);

    for ($i = 0; $i < $count; $i++) {
        $singleFile = [
            'name' => $files['name'][$i] ?? '',
            'type' => $files['type'][$i] ?? '',
            'tmp_name' => $files['tmp_name'][$i] ?? '',
            'error' => $files['error'][$i] ?? UPLOAD_ERR_NO_FILE,
            'size' => $files['size'][$i] ?? 0,
        ];

        if (($singleFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        $uploaded[] = $this->uploadMainImage($singleFile);
    }

    return $uploaded;
}


}