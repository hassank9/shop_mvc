<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\DB;

final class Category
{
    public static function all(): array
    {
        $pdo = DB::pdo();
        return $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll(\PDO::FETCH_ASSOC);
    }
}