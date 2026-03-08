<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\DB;
use PDO;

final class SiteSetting
{
    public static function first(): array
    {
        $pdo = DB::pdo();

        $stmt = $pdo->query("
            SELECT
                id,
                site_name_ar,
                site_name_en,
                site_description,
                logo,
                favicon,
                about_title,
                about_text,
                about_image,
                contact_phone_1,
                contact_phone_2,
                contact_whatsapp,
                contact_email,
                contact_address,
                contact_map_url,
                facebook_url,
                instagram_url,
                telegram_url,
                tiktok_url,
                receipt_store_name,
                receipt_header_text,
                receipt_footer_text,
                receipt_show_logo,
                receipt_show_address,
                receipt_show_contacts,
                receipt_barcode_type,
                receipt_barcode_value,
                low_stock_threshold
            FROM settings
            ORDER BY id ASC
            LIMIT 1
        ");

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: [];
    }
}