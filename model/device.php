<?php

declare(strict_types=1);
require_once('db/db.php');

class Devices extends Db
{

    private $table = "devices";

    public function getAll(): array
    {
        $stmt = $this->conn->query("SELECT * from {$this->table}");
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function create(array $data): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table}(name, type, price) VALUES(:name, :type, :price)");
        return $stmt->execute(
            [
                ":name" => $data['name'] ?? '',
                ":type" => $data['type'] ?? '',
                ":price" => $data['price'] ?? ''
            ]
        );
    }
    public function update(int $id, array $data): bool
    {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET type = :type, name = :name, price = :price WHERE id = :id");
        return $stmt->execute(
            [
                ":name" => $data['name'] ?? '',
                ":type" => $data['type'] ?? '',
                ":price" => $data['price'] ?? '',
                ":id" => $id
            ]
        );
    }
    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=:id");
        return $stmt->execute(
            [
                ":id" => $id
            ]
        );
    }
}
