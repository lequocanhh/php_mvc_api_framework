<?php

namespace app\repository;

use app\models\QuestionEntity;

interface IQuestionRepository
{
    public function createQuestion(QuestionEntity $question): void;
}