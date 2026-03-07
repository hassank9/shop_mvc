<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\DB;
use PDO;

final class Brand
{
    /**
     * جلب كل البراندات مرتبة بالأحدث
     */
    public static function all(): array
    {
        $pdo = DB::pdo();

        $stmt = $pdo->query("
            SELECT id, name, created_at
            FROM brands
            ORDER BY id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * جلب براند واحد بالـ id
     */
    public static function find(int $id): ?array
    {
        $pdo = DB::pdo();

        $stmt = $pdo->prepare("
            SELECT id, name, created_at
            FROM brands
            WHERE id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}