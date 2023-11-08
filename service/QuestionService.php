<?php

namespace app\service;

use app\dto\QuestionResponseDto;
use app\models\QuestionEntity;
use app\models\repository\QuestionRepository;

class QuestionService
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function getQuestionBySurveyId($surveyId): array
    {
        $questions = [];
        $questionList = $this->questionRepository->getQuestionBySurveyId($surveyId);
        foreach ($questionList as $question) {
            $questions[] = [
                'id' => $question['id'],
                'title' => $question['title']
            ];
        }
        return $questions;
    }

    public function createQuestion(QuestionEntity $question): void
    {
        $this->questionRepository->createQuestion($question);
        // ban notificaiton
    }
}