<?php

namespace app\models\repository;

use app\core\Database;
use app\models\QuestionEntity;
use app\repository\IQuestionRepository;
use PDO;

class QuestionRepository extends BaseRepository implements IQuestionRepository
{
    public function __construct(Database $db)
    {
        $this->table = 'questions';
        $this->db = $db;
    }

    public function getQuestionBySurveyId($surveyId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE survey_id = :id");
        $stmt->bindValue(':id', $surveyId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateQuestion(QuestionEntity $question): void
    {
        parent::update($question->toArray());
    }

    public function createQuestion(QuestionEntity $question): void
    {
        parent::save($question);
    }

    public function deleteQuestion($id): void
    {
        parent::delete($id);
    }

    public function deleteQuestionBySurveyId($id): void
    {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE survey_id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }

}