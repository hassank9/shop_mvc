<?php

namespace App\Admin\Models;

use PDO;

class Admin
{
    protected PDO $db;
    protected string $table = 'admins';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findByUsername(string $username): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username AND is_active = 1 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id AND is_active = 1 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}