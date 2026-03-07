<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\DB;

final class User
{
    public static function findByPhone(string $phone): ?array
    {
        $pdo = DB::pdo();
        $st = $pdo->prepare("SELECT id, full_name, phone, address, password_hash FROM users WHERE phone = :p LIMIT 1");
        $st->execute([':p' => $phone]);
        $row = $st->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function findById(int $id): ?array
    {
        $pdo = DB::pdo();
        $st = $pdo->prepare("SELECT id, full_name, phone, address, password_hash FROM users WHERE id = :id LIMIT 1");
        $st->execute([':id' => $id]);
        $row = $st->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function create(string $fullName, string $phone, string $address, string $password): int
    {
        $pdo = DB::pdo();
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $st = $pdo->prepare("
            INSERT INTO users (full_name, phone, address, password_hash)
            VALUES (:n, :p, :a, :h)
        ");
        $st->execute([
            ':n' => $fullName,
            ':p' => $phone,
            ':a' => $address,
            ':h' => $hash,
        ]);

        return (int)$pdo->lastInsertId();
    }
}