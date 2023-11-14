<?php

namespace service;

use app\exception\SurveyException;
use app\models\repository\SurveyRepository;
use app\models\SurveyEntity;
use app\service\SurveyService;
use http\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;

class SurveyServiceTest extends TestCase
{
    private $surveyRepositoryMock;
    private SurveyService $surveyService;
    public function setUp(): void
    {
        parent::setUp();
        $this->surveyRepositoryMock = $this->createMock(SurveyRepository::class);
        $this->surveyService = new SurveyService($this->surveyRepositoryMock);
    }

    /**
     * @throws SurveyException
     */
    public function testGetSurveyByIdSuccess()
    {
        $id = "ed0bb247-c02d-4adb-8aea-f3cdceb51dad";
        $surveyExist = new SurveyEntity("ed0bb247-c02d-4adb-8aea-f3cdceb51dad", "title", "description", 0, $id, "2023-11-12 15:36:27");
        $this->surveyRepositoryMock
            ->expects($this->once())
            ->method('getSurveyById')
            ->with($id)
            ->willReturn($surveyExist);

        $result = $this->surveyService->getSurveyById($id);

        $this->assertEquals([
            'id' => $surveyExist->getId(),
            'title' => $surveyExist->getTitle(),
            'description' => $surveyExist->getDescription()
        ], $result);
    }

    /**
     * @throws SurveyException
     */
    public function testGetSurveyWithInvalidId()
    {
        $id = "ed0bb247-c02d-4adb-8aea-f3cdceb51dad";

        $this->surveyRepositoryMock
            ->expects($this->once())
            ->method('getSurveyById')
            ->with($id)
            ->willReturn(null);

        $this->expectException(SurveyException::class);
        $this->surveyService->getSurveyById($id);
    }


    /**
     * @throws SurveyException
     */
    public function testGetStatisticSurveyByIdSuccess()
    {
        $id = "ed0bb247-c02d-4adb-8aea-f3cdceb51dad";
        $surveyExist = new SurveyEntity("ed0bb247-c02d-4adb-8aea-f3cdceb51dad", "title", "description", 0, $id, "2023-11-12 15:36:27");
        $this->surveyRepositoryMock
            ->expects($this->once())
            ->method("getSurveyById")
            ->with($id)
            ->willReturn($surveyExist);

        $result = $this->surveyService->getStatisticSurveyById($id);
        $this->assertEquals($surveyExist->toArray(), $result);
    }

    /**
     * @throws SurveyException
     */
    public function testGetStatisticSurveyByInvalidId()
    {
        $id = "wrong-id-4adb-8aea-f3cdceb51dad";
        $this->surveyRepositoryMock
            ->expects($this->once())
            ->method("getSurveyById")
            ->with($id)
            ->willReturn(null);
        $this->expectException(SurveyException::class);
        $this->surveyService->getStatisticSurveyById($id);
    }


    /**
     * @throws SurveyException
     */
    public function testUpdateParticipantRecordSuccess()
    {
        $id = "ed0bb247-c02d-4adb-8aea-f3cdceb51dad";
        $this->surveyRepositoryMock
            ->expects($this->once())
            ->method("updateParticipantRecord")
            ->with($id)
            ->willReturn(true);
        $result = $this->surveyService->updateParticipantRecord($id);
        $this->assertTrue($result);
    }

    public function testUpdateParticipantRecordFailed()
    {
        $id = "wrong-id-4adb-8aea-f3cdceb51dad";
        $this->surveyRepositoryMock
            ->expects($this->once())
            ->method("updateParticipantRecord")
            ->with($id)
            ->willReturn(false);
        $this->expectException(SurveyException::class);
        $this->surveyService->updateParticipantRecord($id);
    }

}
