<?php

namespace App\Admin\Models;

use PDO;

class UserManager
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

public function getAllUsers(): array
{
    $sql = "
        SELECT
            id,
            full_name,
            phone,
            address,
            created_at
        FROM users
        ORDER BY id DESC
    ";

    $stmt = $this->db->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

    public function getAllAdmins(): array
    {
        $sql = "
            SELECT
                id,
                username,
                full_name,
                role,
                created_at
            FROM admins
            ORDER BY id DESC
        ";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function updateUser(int $id, string $fullName, string $phone, string $address): bool
{
    $fullName = trim($fullName);
    $phone = trim($phone);
    $address = trim($address);

    if ($id <= 0 || $fullName === '' || $phone === '' || $address === '') {
        return false;
    }

    $sql = "
        UPDATE users
        SET
            full_name = :full_name,
            phone = :phone,
            address = :address
        WHERE id = :id
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':full_name' => $fullName,
        ':phone' => $phone,
        ':address' => $address,
        ':id' => $id,
    ]);
}

public function updateAdmin(int $id, string $fullName, string $username, string $role): bool
{
    $fullName = trim($fullName);
    $username = trim($username);
    $role = trim($role);

    if ($id <= 0 || $fullName === '' || $username === '' || $role === '') {
        return false;
    }

    $sql = "
        UPDATE admins
        SET
            full_name = :full_name,
            username = :username,
            role = :role
        WHERE id = :id
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':full_name' => $fullName,
        ':username' => $username,
        ':role' => $role,
        ':id' => $id,
    ]);
}

public function deleteUser(int $id): bool
{
    if ($id <= 0) {
        return false;
    }

    $sql = "
        DELETE FROM users
        WHERE id = :id
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':id' => $id,
    ]);
}

public function deleteAdmin(int $id): bool
{
    if ($id <= 0) {
        return false;
    }

    $sql = "
        DELETE FROM admins
        WHERE id = :id
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':id' => $id,
    ]);
}

}