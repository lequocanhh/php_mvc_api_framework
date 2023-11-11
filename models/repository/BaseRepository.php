<?php

namespace app\models\repository;

use app\core\Database;
use PDO;

class BaseRepository
{
    protected string $table;
    protected Database $db;

    public function getAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function find($column, $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE $column = :column");
        $stmt->bindValue(':column', $value);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public function update($data): void
    {
        $column = array_keys($data);
        $params = implode(", ", array_map(fn($key) => "$key = :$key", $column));
        $stmt = $this->db->prepare("UPDATE $this->table SET $params WHERE id = :id");
        foreach ($data as $key => $value){
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
    }

    public function save($data): void
    {
        $params= implode(', ',array_map(fn($key) => ":$key", array_keys($data->toArray())));
        $columns = implode(', ', array_keys($data->toArray()));
        $stmt = $this->db->prepare("INSERT INTO $this->table ($columns) VALUES ($params)");
        foreach ($data->toArray() as $key => $value) {
            $stmt->bindValue(":$key",  $value);
        }
        $stmt->execute();
    }

    public function delete($id): void
    {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }

}