<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\SiteSetting;

final class AboutController extends Controller
{
    public function index(): void
    {
        $siteSettings = SiteSetting::first();

        $siteName = trim((string)($siteSettings['site_name_ar'] ?? ''));
        if ($siteName === '') {
            $siteName = trim((string)($siteSettings['site_name_en'] ?? ''));
        }
        if ($siteName === '') {
            $siteName = 'FirstClass';
        }

        $this->view('about/index', [
            'title' => 'من نحن',
            'siteSettings' => $siteSettings,
            'siteName' => $siteName,
        ]);
    }
}