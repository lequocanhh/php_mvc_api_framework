<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\repository\QuestionRepository;
use app\models\SurveyEntity;
use app\service\SurveyService;
use Exception;
use Ramsey\Uuid\Uuid;

class SurveyController
{
    private SurveyService $surveyService;
    private QuestionRepository $questionRepository;

    public function __construct(SurveyService $surveyService, QuestionRepository $questionRepository)
    {
        $this->surveyService = $surveyService;
        $this->questionRepository = $questionRepository;
    }
    public function createNewSurvey(Request $request, Response $response): void
    {
        $req = $request->getBody();
        $title = $req['title'];
        $description = $req['description'];
        $created_by = $req['created_by'];
        $now = new \DateTime();
        $created_at = $now->format('Y-m-d H:i:s');
        $questions = $req['questions'];

        try {
            $surveyEntity = new SurveyEntity(Uuid::uuid4(), $title, $description, 0, $created_by, $created_at);
            $this->surveyService->createSurvey($surveyEntity);



            $response->render(200, 'Create a survey successfully');
        }catch (Exception $error){
            $response->render(404, "Cannot save this survey");
            throw new \Error("Cannot save this survey to db .$error");
        }

    }
}