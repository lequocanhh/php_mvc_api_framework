<?php

namespace app\models\repository;

use app\core\Database;
use app\models\QuestionEntity;
use app\repository\IQuestionRepository;

class QuestionRepository extends BaseRepository implements IQuestionRepository
{
    public function __construct(Database $db)
    {
        $this->table = 'questions';
        $this->db = $db;
    }

    public function createQuestion(QuestionEntity $question): void
    {
        parent::save($question);
    }
}