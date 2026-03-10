<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\HeroSlide;
use App\Models\SiteSetting;

final class HomeController extends Controller
{
    public function index(): void
    {
        $products = Product::latest(12);
        $categories = Category::all();
        $brands = Brand::all();
        $best       = Product::bestSellers(8);
        $heroSlides = HeroSlide::activeAll();
        $siteSettings = SiteSetting::first();

        // ✅ الأكثر مبيعًا (آخر 30 يوم) — يظهر فقط إذا توجد طلبات Completed
        $best = Product::bestSellers(30, 8);

        $this->view('home/index', [
            'title' => ' ',
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'best' => $best, // ✅ جديد
            'heroSlides' => $heroSlides,
            'siteSettings' => $siteSettings,
        ]);
    }
}