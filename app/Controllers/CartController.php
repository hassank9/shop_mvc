<?php
declare(strict_types=1);

namespace App\Controllers;

final class CartController extends Controller
{
    public function index(): void
    {
        $this->view('cart/index', [
            'title' => 'سلة المشتريات'
        ]);
    }
}