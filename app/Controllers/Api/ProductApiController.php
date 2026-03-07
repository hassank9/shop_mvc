<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use App\Helpers\Response;
use App\Models\Product;

final class ProductApiController
{
    public function search(): void
    {
        $q = isset($_GET['q']) ? (string)$_GET['q'] : '';
        $q = mb_substr($q, 0, 80); // حد بسيط

        $items = Product::search($q, 12);

        Response::json([
            'ok' => true,
            'count' => count($items),
            'items' => $items,
        ]);
    }

    public function browse(): void
    {
    $data = \App\Models\Product::browse([
        'q' => $_GET['q'] ?? '',
        'category_id' => $_GET['category_id'] ?? 0,
        'brand_id' => $_GET['brand_id'] ?? 0,
        'sort' => $_GET['sort'] ?? 'new',
        'page' => $_GET['page'] ?? 1,
        'per_page' => $_GET['per_page'] ?? 12,
    ]);

    \App\Helpers\Response::json(['ok' => true] + $data);
    }

}