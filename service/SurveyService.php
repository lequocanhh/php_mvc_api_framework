<?php

namespace app\service;

use app\dto\SurveyDto;
use app\exception\SurveyException;
use app\models\QuestionEntity;
use app\models\repository\SurveyRepository;
use app\models\SurveyEntity;
use RuntimeException;

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

    /**
     * @throws SurveyException
     */
    public function getSurveyById($id): array
    {
        $surveyExist = $this->surveyRepository->getSurveyById($id);
        !$surveyExist && throw SurveyException::surveyNotFound();
        $surveyResponse = new SurveyDto($surveyExist->getId(), $surveyExist->getTitle(), $surveyExist->getDescription());
        return $surveyResponse->toArray();
    }

    /**
     * @throws SurveyException
     */
    public function getStatisticSurveyById($id): array
    {
        $surveyExist = $this->surveyRepository->getSurveyById($id);
        !$surveyExist && throw SurveyException::surveyNotFound();
        $surveyResponse = new SurveyEntity($surveyExist->getId(), $surveyExist->getTitle(), $surveyExist->getDescription(), $surveyExist->getParticipant(), $surveyExist->getCreatedBy(), $surveyExist->getCreatedAt());
        return $surveyResponse->toArray();
    }

    public function createSurvey(SurveyEntity $survey): void
    {
        $this->surveyRepository->createSurvey($survey);
    }

    public function updateSurvey(SurveyDto $survey): void
    {
       $this->surveyRepository->updateSurvey($survey);
    }

    public function updateParticipantRecord($id): bool
    {
       $isUpdated = $this->surveyRepository->updateParticipantRecord($id);
       return $isUpdated ? true : throw new RuntimeException("Cannot send this record, please try again!");
    }

    public function createQuestion(QuestionEntity $question): void
    {

    }
}