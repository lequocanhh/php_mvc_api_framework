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

    public function getAllSurvey(): array
    {
        return parent::getAll();
    }

//    public function getAllSurvey()
//    {
//        $stmt = $this->db->prepare(
//            "SELECT DISTINCT s.id, s.title AS survey_title, s.description AS survey_description, q.title AS question_title, o.title AS option_title
//                FROM surveys s
//                JOIN users u ON (u.id = s.created_by)
//                JOIN questions q ON (q.survey_id = s.id)
//                LEFT JOIN options o ON (o.question_id = q.id)
//                WHERE s.created_by = u.id");
//            $stmt->execute();
//           return $stmt->fetchAll();
//    }

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