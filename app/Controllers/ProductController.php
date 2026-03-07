<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Response;
use App\Models\Product;

final class ProductController extends Controller
{
    public function show(): void
    {
        $slug = isset($_GET['slug']) ? (string)$_GET['slug'] : '';
        $slug = trim($slug);

        if ($slug === '') {
            Response::html('Product slug required', 400);
        }

        $product = Product::findBySlug($slug);
        if (!$product) {
            Response::html('Product not found', 404);
        }

        $images = \App\Models\Product::imagesByProductId((int)$product['id']);
        $related = [];
        if (!empty($product['category_id'])) {
            $related = Product::related((int)$product['category_id'], (int)$product['id'], 8);
        }

        $this->view('product/show', [
            'title' => $product['name'],
            'product' => $product,
            'images' => $images,
            'related' => $related,
        ]);
    }
}