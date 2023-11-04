<?php

namespace app\models\repository;

use app\core\Database;

class BaseRepository
{
    protected string $table;
    protected Database $db;


    public function find($column, $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE $column = :column");
        $stmt->bindValue(':column', $value);
        $stmt->execute();
        return $stmt->fetchObject();
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



}