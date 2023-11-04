<?php

namespace app\repository;

use app\models\SurveyEntity;

interface ISurveyRepository
{
    public function create(SurveyEntity $survey): void;
}