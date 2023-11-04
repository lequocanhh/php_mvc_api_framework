<?php

namespace app\service;

use app\models\repository\SurveyRepository;
use app\models\SurveyEntity;

class SurveyService
{
    private SurveyRepository $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function createSurvey(SurveyEntity $survey): void
    {
        $this->surveyRepository->create($survey);
    }
}