<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\SiteSetting;

final class ContactController extends Controller
{
    public function index(): void
    {
        $siteSettings = SiteSetting::first();

        $siteName = trim((string)($siteSettings['site_name_ar'] ?? ''));
        if ($siteName === '') {
            $siteName = trim((string)($siteSettings['site_name_en'] ?? ''));
        }
        if ($siteName === '') {
            $siteName = 'Store';
        }

        $this->view('contact/index', [
            'title' => 'تواصل معنا',
            'siteSettings' => $siteSettings,
            'siteName' => $siteName,
        ]);
    }
}