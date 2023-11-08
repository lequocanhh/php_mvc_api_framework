<?php

namespace app\service;

use app\dto\SurveyResponseDto;
use app\models\QuestionEntity;
use app\models\repository\SurveyRepository;
use app\models\SurveyEntity;

class SurveyService
{
    private SurveyRepository $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function getAllSurvey(): array
    {
        return $this->surveyRepository->getAllSurvey();
    }

    public function getSurveyById($id): array
    {
        $data = $this->surveyRepository->getSurveyById($id);
        return [
                'id' => $data->getId(),
                'title' => $data->getTitle(),
                'description' => $data->getDescription()
            ];
    }

    public function createSurvey(SurveyEntity $survey): void
    {
        $this->surveyRepository->createSurvey($survey);
    }

    public function createQuestion(QuestionEntity $question): void
    {

    }
}