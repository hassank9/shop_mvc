<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

final class HomeController extends Controller
{
    public function index(): void
    {
        $products = Product::latest(12);
        $categories = Category::all();
        $brands = Brand::all();

        // ✅ الأكثر مبيعًا (آخر 30 يوم) — يظهر فقط إذا توجد طلبات Completed
        $best = Product::bestSellers(30, 8);

        $this->view('home/index', [
            'title' => 'FirstClass Shop',
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'best' => $best, // ✅ جديد
        ]);
    }
}