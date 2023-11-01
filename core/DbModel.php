<?php

namespace app\core;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $stmt =  self::prepare("INSERT INTO $tableName 
                        (".implode(',', $attributes).") 
                        VALUES(".implode(',', $params).")");

        foreach ($attributes as $attribute) {
            $stmt->bindValue(":$attribute",  $this->{$attribute});
        }

        $stmt->execute();
        return true;
    }
    
    public function findOne(array $data)
    {
        $tableName = $this->tableName();
        $attributes = array_keys($data);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($data as $key => $value){
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchObject(static::class);
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}