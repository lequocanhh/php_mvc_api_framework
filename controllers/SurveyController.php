<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\OptionEntity;
use app\models\QuestionEntity;
use app\models\repository\SurveyRepository;
use app\models\SurveyEntity;
use app\runtime\dto\SurveyDto;
use app\service\OptionService;
use app\service\QuestionService;
use app\service\SurveyService;
use DateTime;
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

    public function getAllSurvey(Request $request, Response $response): void
    {
        try {
            $data = $this->surveyService->getAllSurvey();
            $response->render(200, 'Get all survey successfully', $data);
        }catch (Exception $error){
            echo $error;
            $response->render(400, "Cannot get any survey");
        }
    }

    public function getSurveyIndividual(Request $request, Response $response, string $userId): void
    {
        try {
            $data = $this->surveyService->getSurveyByUserId($userId);
            $response->render(200, 'Get all survey successfully', $data);
        }catch (Exception $error){
            echo $error;
            $response->render(400, "Cannot get any survey");
        }
    }

    public function getSurveyById(Request $request, Response $response, string $id): void
    {
        $questionSet = [];
        try {
            $survey = $this->surveyService->getSurveyById($id);
            $questions = $this->questionService->getQuestionBySurveyId($id);

            foreach ($questions as $question) {
                $options = $this->optionService->getAllOptionByQuestionId($question['id']);
                    $questions = [
                        'id' => $question['id'],
                        'title' => $question['title'],
                        'options' => $options
                    ];
                 $questionSet[] = $questions;
            }
            $survey['questions'] = $questionSet;

            $response->render(200, 'Get a survey successfully', $survey);
        }catch (Exception $error){
            $response->render(400, "Cannot get any survey");
            echo $error;
        }
    }

    public function getStatisticSurveyById(Request $request, Response $response, string $id): void
    {
        $questionSet = [];
        try {
            $survey = $this->surveyService->getStatisticSurveyById($id);
            $questions = $this->questionService->getQuestionBySurveyId($id);

            foreach ($questions as $question) {
                $options = $this->optionService->getStatisticOptionByQuestionId($question['id']);
                $questions = [
                    'id' => $question['id'],
                    'title' => $question['title'],
                    'options' => $options
                ];
                $questionSet[] = $questions;
            }
            $survey['questions'] = $questionSet;

            $response->render(200, 'Get a survey successfully', $survey);
        }catch (Exception $error){
            $response->render(400, "Cannot get any survey");
            echo $error;
        }
    }


    public function createNewSurvey(Request $request, Response $response): void
    {
        $now = new DateTime();
        $req = $request->getBody();
        $title = $req['title'];
        $description = $req['description'];
        $created_by = $req['created_by'];
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
                    $optionEntity = new OptionEntity(Uuid::uuid4(), $questionEntity->getId(), $option['title'], 0);
                    $this->optionService->createOption($optionEntity);
                }
            }
            $this->surveyRepository->commit();
            $response->render(200, 'Create a survey successfully');
        }catch (Exception $error){
            $this->surveyRepository->rollback();
            $response->render(400, "Cannot create this survey, please try again");
            echo $error;
        }
    }

    public function updateSurvey(Request $request, Response $response): void
    {
        $req = $request->getBody();
        $questions = $req['questions'];
        $surveyId = $req['id'];

        $this->surveyRepository->beginTransaction();
        try {
            $survey = new SurveyDto($surveyId, $req['title'], $req['description']);
            $this->surveyService->updateSurvey($survey);
            $this->questionService->updateQuestion($surveyId, $questions);

            $this->surveyRepository->commit();
            $response->render(200, 'Update survey successfully');
        }catch (Exception $error){
            $this->surveyRepository->rollback();
            var_dump($error->getMessage());
            $response->render(400, "Cannot update this survey, please try again");

        }

    }

    public function updateRecordDoSurvey(Request $request, Response $response): void
    {
        $req = $request->getBody();
        $surveyId = $req['survey_id'];
        $optionAnswerRecord = $req["ids"];

        $this->surveyRepository->beginTransaction();
        try {
            $this->surveyService->updateParticipantRecord($surveyId);
            foreach ($optionAnswerRecord as $recordId){
               $this->optionService->updateOptionRecord($recordId);
            }
            $this->surveyRepository->commit();
            $response->render(200, 'Save record successfully');
        } catch (Exception $error){
            $this->surveyRepository->rollback();
            $response->render(400, $error->getMessage());
        }
    }

    public function deleteSurvey(Request $request, Response $response, string $id): void
    {
        $this->surveyRepository->beginTransaction();
        try {
            $questions = $this->questionService->getQuestionBySurveyId($id);
            foreach ($questions as $question){
                $this->optionService->deleteOptionByQuestionId($question['id']);
            }
            $this->questionService->deleteQuestionBySurveyId($id);
            $this->surveyRepository->delete($id);

            $this->surveyRepository->commit();
            $response->render(200, 'Delete survey successfully');
        }catch (Exception $error){
            $this->surveyRepository->rollback();
            $response->render(400, $error->getMessage());
        }

    }
}