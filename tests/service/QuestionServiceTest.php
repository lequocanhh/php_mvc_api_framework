<?php

namespace service;

use app\exception\QuestionException;
use app\models\QuestionEntity;
use app\models\repository\OptionRepository;
use app\models\repository\QuestionRepository;
use app\service\OptionService;
use app\service\QuestionService;
use PHPUnit\Framework\TestCase;

class QuestionServiceTest extends TestCase
{
    private $questionRepositoryMock;
    private $optionServiceMock;
    private QuestionService $questionService;
    public function setUp(): void
    {
        parent::setUp();
        $this->questionRepositoryMock = $this->createMock(QuestionRepository::class);
        $this->optionServiceMock = $this->createMock(OptionService::class);
        $this->questionService = new QuestionService($this->questionRepositoryMock, $this->optionServiceMock);
    }


    /**
     * @throws QuestionException
     */
    public function testGetQuestionBySurveyIdSuccess()
    {
        $surveyId = "ed0bb247-c02d-4adb-8aea-f3cdceb51dad";

        $mockedQuestionList = [
            ['id' => 'question1', 'title' => 'Question 1'],
            ['id' => 'question2', 'title' => 'Question 2'],
        ];

        $this->questionRepositoryMock
            ->expects($this->once())
            ->method("getQuestionBySurveyId")
            ->with($surveyId)
            ->willReturn($mockedQuestionList);


        $result = $this->questionService->getQuestionBySurveyId($surveyId);
        $this->assertEquals([
            ['id' => 'question1', 'title' => 'Question 1'],
            ['id' => 'question2', 'title' => 'Question 2'],
        ], $result);
    }

    /**
     * @throws QuestionException
     */
    public function testGetQuestionBySurveyIdWithNoQuestionFound()
    {
        $surveyId = "wrong-id-4adb-8aea-f3cdceb51dad";

        $this->questionRepositoryMock
            ->expects($this->once())
            ->method("getQuestionBySurveyId")
            ->with($surveyId)
            ->willReturn([]);

        $this->expectException(QuestionException::class);
        $this->questionService->getQuestionBySurveyId($surveyId);
    }



}
