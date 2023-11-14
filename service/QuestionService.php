<?php

namespace app\service;

use app\exception\QuestionException;
use app\models\QuestionEntity;
use app\models\repository\QuestionRepository;
use app\runtime\dto\QuestionResponseDto;
use Ramsey\Uuid\Uuid;

class QuestionService
{
    private QuestionRepository $questionRepository;
    private OptionService $optionService;

    public function __construct(QuestionRepository $questionRepository, OptionService $optionService)
    {
        $this->questionRepository = $questionRepository;
        $this->optionService = $optionService;
    }

    /**
     * @return QuestionResponseDto[]
     * @throws QuestionException
     */
    public function getQuestionBySurveyId($surveyId): array
    {
        $questions = [];
        $questionList = $this->questionRepository->getQuestionBySurveyId($surveyId);
        empty($questionList) && throw QuestionException::questionNotFound();
        foreach ($questionList as $question) {
            $questionsResponse = new QuestionResponseDto($question['id'], $question['title']);
            $questions[] = $questionsResponse->toArray();
        }
        return $questions;
    }

    public function createQuestion(QuestionEntity $question): void
    {
        $this->questionRepository->createQuestion($question);
    }

    /**
     * @throws QuestionException
     */
    public function updateQuestion($surveyId, $newQuestions): void
    {
        $oldQuestions = $this->getQuestionBySurveyId($surveyId);
        $questionToUpdate = [];
        foreach ($oldQuestions as $oldQuestion){
            $oldQuestionId = $oldQuestion['id'];
            $question = array_filter($newQuestions, function($q) use($oldQuestionId) {
                return isset($q['id']) && $oldQuestionId === $q['id'];
            });
            $question && $questionToUpdate[] = $question;
        }
        $newQuestionToAdd[] = array_filter($newQuestions, function($q) {
            return !array_key_exists('id', $q);
        });
        $questionToDelete[] = array_udiff($oldQuestions, $newQuestions, function ($a, $b) {
            $idA = $a['id'] ?? null;
            $idB = $b['id'] ?? null;
            return $idA <=> $idB;
        });

            if(!empty($questionToUpdate)){
                foreach ($questionToUpdate as $questionData){
                    foreach ($questionData as $question){
                        $questionUpdateEntity = new QuestionEntity($question['id'], $surveyId,  $question['title']);
                        $this->optionService->updateOption($question['id'], $question['options']);
                    $this->questionRepository->updateQuestion($questionUpdateEntity);
                    }
                }
            }

            if(!empty($newQuestionToAdd)){
                foreach ($newQuestionToAdd as $questionData){
                    foreach ($questionData as $question) {
                        $questionCreateEntity = new QuestionEntity(Uuid::uuid4(), $surveyId, $question['title']);
                        $this->questionRepository->createQuestion($questionCreateEntity);
                        $this->optionService->createOptionByQuestionId($questionCreateEntity->getId(), $question['options']);
                    }
                }
            }

            if(!empty($questionToDelete)){
                foreach ($questionToDelete as $questionData){
                    foreach ($questionData as $question){
                       $this->optionService->deleteOptionByQuestionId($question['id']);
                        $this->questionRepository->deleteQuestion($question['id']);
                    }
                }
            }

    }

    public function deleteQuestionBySurveyId($id): void
    {
        $this->questionRepository->deleteQuestionBySurveyId($id);
    }

}