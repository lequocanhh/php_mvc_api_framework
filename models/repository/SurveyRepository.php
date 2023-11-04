<?php

namespace app\models\repository;

use app\core\Database;
use app\models\SurveyEntity;
use app\repository\ISurveyRepository;

class SurveyRepository extends BaseRepository implements ISurveyRepository
{
    public function __construct(Database $db)
    {
        $this->table = 'surveys';
        $this->db = $db;
    }

    public function create(SurveyEntity $survey): void
    {
       parent::save($survey);
    }
}