<?php

namespace app\models\repository;

use app\core\Database;
use app\models\QuestionEntity;
use app\models\SurveyEntity;
use app\repository\ISurveyRepository;

class SurveyRepository extends BaseRepository implements ISurveyRepository
{
    public function __construct(Database $db)
    {
        $this->table = 'surveys';
        $this->db = $db;
    }

    public function createSurvey(SurveyEntity $survey): void
    {
       parent::save($survey);
    }

    public function createQuestion(QuestionEntity $question):void
    {
        parent::save($question);
    }

    public function beginTransaction(): void
    {
        $this->db->pdo->beginTransaction();
    }

    public function commit(): void
    {
        $this->db->pdo->commit();
    }

    public function rollback(): void
    {
        $this->db->pdo->rollBack();
    }

}