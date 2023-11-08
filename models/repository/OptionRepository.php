<?php

namespace app\models\repository;

use app\core\Database;
use app\models\OptionEntity;
use app\repository\IOptionRepository;
use PDO;

class OptionRepository extends BaseRepository implements IOptionRepository
{
    public function __construct(Database $db)
    {
        $this->table = 'options';
        $this->db = $db;
    }

    public function getAllOptionByQuestionId($id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE question_id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createOption(OptionEntity $option): void
    {
        parent::save($option);
    }
}