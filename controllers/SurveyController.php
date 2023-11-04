<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\OptionEntity;
use app\models\QuestionEntity;
use app\models\repository\SurveyRepository;
use app\models\SurveyEntity;
use app\service\OptionService;
use app\service\QuestionService;
use app\service\SurveyService;
use Exception;
use Ramsey\Uuid\Uuid;

class SurveyController
{
    private SurveyRepository $surveyRepository;
    private SurveyService $surveyService;
    private QuestionService $questionService;
    private OptionService $optionService;

    public function __construct(SurveyRepository $surveyRepository, SurveyService $surveyService, QuestionService $questionService, OptionService $optionService)
    {
        $this->surveyRepository = $surveyRepository;
        $this->surveyService = $surveyService;
        $this->questionService = $questionService;
        $this->optionService = $optionService;
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

        $this->surveyRepository->beginTransaction();
        try {
            $surveyEntity = new SurveyEntity(Uuid::uuid4(), $title, $description, 0, $created_by, $created_at);
            $this->surveyService->createSurvey($surveyEntity);
            foreach ($questions as $question){
                $questionEntity = new QuestionEntity(Uuid::uuid4(), $surveyEntity->getId(), $question['title']);
                $this->questionService->createQuestion($questionEntity);

                foreach ($question['options'] as $option){
                    $optionEntity = new OptionEntity(Uuid::uuid4(), $questionEntity->getId(), $option, 0);
                    $this->optionService->createOption($optionEntity);
                }

            }
            $this->surveyRepository->commit();
            $response->render(200, 'Create a survey successfully');
        }catch (Exception $error){
            $this->surveyRepository->rollback();
            $response->render(404, "Cannot save this survey");
            throw new \Error("Cannot save this survey to db .$error");
        }

    }
}