<?php

namespace app\repository;

use app\models\QuestionEntity;
use app\models\SurveyEntity;

interface ISurveyRepository
{
    public function createSurvey(SurveyEntity $survey): void;
    public function createQuestion(QuestionEntity $question): void;
}