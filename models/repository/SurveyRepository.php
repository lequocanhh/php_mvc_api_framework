<?php

namespace app\models\repository;

use app\core\Database;
use app\exception\SurveyException;
use app\models\QuestionEntity;
use app\models\SurveyEntity;
use app\repository\ISurveyRepository;
use app\runtime\dto\SurveyDto;
use PDO;

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

    /**
     * @throws SurveyException
     */
    public function getSurveyById($id): ?SurveyEntity
    {
        $surveyEntity = parent::findById($id);
        if ($surveyEntity){
            return new SurveyEntity($surveyEntity->id, $surveyEntity->title, $surveyEntity->description, $surveyEntity->participant, $surveyEntity->created_by, $surveyEntity->created_at);
        }
       return null;
    }

    public function getSurveyByUserId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE created_by = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createSurvey(SurveyEntity $survey): void
    {
       parent::save($survey);
    }

    public function createQuestion(QuestionEntity $question):void
    {
        parent::save($question);
    }

    public function updateSurvey(SurveyDto $survey): void
    {
         parent::update($survey->toArray());
    }

    public function updateParticipantRecord($id): bool
    {
        $stmt = $this->db->prepare("UPDATE $this->table SET participant = participant+1 WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
        return $rowCount > 0;
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