<?php

namespace App\Admin\Models;

use PDO;

class Category
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $sql = "
            SELECT
                id,
                name,
                created_at
            FROM categories
            ORDER BY id DESC
        ";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function findById(int $id): array|false
{
    $sql = "
        SELECT
            id,
            name,
            created_at
        FROM categories
        WHERE id = :id
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':id' => $id,
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function create(string $name): bool
{
    $name = trim($name);

    if ($name === '') {
        return false;
    }

    $sql = "INSERT INTO categories (name) VALUES (:name)";
    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':name' => $name,
    ]);
}

public function update(int $id, string $name): bool
{
    $name = trim($name);

    if ($id <= 0 || $name === '') {
        return false;
    }

    $sql = "UPDATE categories SET name = :name WHERE id = :id LIMIT 1";
    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':name' => $name,
        ':id' => $id,
    ]);
}

public function delete(int $id): bool
{
    if ($id <= 0) {
        return false;
    }

    $sql = "DELETE FROM categories WHERE id = :id LIMIT 1";
    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':id' => $id,
    ]);
}

}