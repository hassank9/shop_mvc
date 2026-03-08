<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\DB;
use PDO;

final class HeroSlide
{
    public static function activeAll(): array
    {
        $pdo = DB::pdo();

        $stmt = $pdo->query("
            SELECT
                id,
                title,
                subtitle,
                button_text_1,
                button_link_1,
                button_text_2,
                button_link_2,
                image,
                sort_order,
                is_active
            FROM hero_slides
            WHERE is_active = 1
            ORDER BY sort_order ASC, id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}