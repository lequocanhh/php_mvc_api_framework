<?php

namespace app\service;

use app\models\QuestionEntity;
use app\models\repository\QuestionRepository;

class QuestionService
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function createQuestion(QuestionEntity $question): void
    {
        $this->questionRepository->createQuestion($question);
    }
}