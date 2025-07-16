<?php
// car.php

declare(strict_types=1);
require_once("database.php");

class Car extends Database {
    private $table = "cars";

    public function getAll(): array {
        $stmt = $this->conn->query("SELECT * FROM $this->table");
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getCarByID(int $id): array {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function create(array $data): bool {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (make, model, year, price, description) 
             VALUES (:make, :model, :year, :price, :description)"
        );
        return $stmt->execute([
            ":make" => $data["make"] ?? '',
            ":model" => $data["model"] ?? '',
            ":year" => (int) ($data["year"] ?? 0),
            ":price" => (float) ($data["price"] ?? 0.00),
            ":description" => $data["description"] ?? ''
        ]);
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table} 
             SET make = :make, model = :model, year = :year, price = :price, description = :description 
             WHERE id = :id"
        );
        return $stmt->execute([
            ":make" => $data["make"] ?? '',
            ":model" => $data["model"] ?? '',
            ":year" => (int) ($data["year"] ?? 0),
            ":price" => (float) ($data["price"] ?? 0.00),
            ":description" => $data["description"] ?? '',
            ":id" => $id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>