<?php

namespace service;

use app\models\OptionEntity;
use app\models\repository\OptionRepository;
use app\service\OptionService;
use PHPUnit\Framework\TestCase;

class OptionServiceTest extends TestCase
{
    private $optionRepositoryMock;
    private OptionService $optionService;
    public function setUp(): void
    {
        parent::setUp();
        $this->optionRepositoryMock = $this->createMock(OptionRepository::class);
        $this->optionService = new OptionService($this->optionRepositoryMock);
    }

    public function testGetAllOptionByQuestionIdSuccess()
    {
        $questionId = '123';
        $optionsData = [
            ['id' => '1', 'title' => 'Option 1'],
            ['id' => '2', 'title' => 'Option 2'],
        ];

        $this->optionRepositoryMock
            ->expects($this->once())
            ->method('getAllOptionByQuestionId')
            ->with($questionId)
            ->willReturn($optionsData);

        $result = $this->optionService->getAllOptionByQuestionId($questionId);

        $expectedResult = [
            ['id' => '1', 'title' => 'Option 1'],
            ['id' => '2', 'title' => 'Option 2'],
        ];
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetAllOptionByQuestionIdWithNoOptionFound()
    {
        $questionId = '456';

        $this->optionRepositoryMock
            ->expects($this->once())
            ->method('getAllOptionByQuestionId')
            ->with($questionId)
            ->willReturn([]);

        $result = $this->optionService->getAllOptionByQuestionId($questionId);

        $this->assertEquals([], $result);
    }

    public function testGetStatisticOptionByQuestionIdWithIdExist()
    {
        // Arrange
        $questionId = '123';
        $optionsData = [
            ['id' => '1', 'question_id' => '123', 'title' => 'Option 1', 'chooser' => 3],
            ['id' => '2', 'question_id' => '123', 'title' => 'Option 2', 'chooser' => 5],
        ];

        $this->optionRepositoryMock
            ->expects($this->once())
            ->method('getAllOptionByQuestionId')
            ->with($questionId)
            ->willReturn($optionsData);

        $result = $this->optionService->getStatisticOptionByQuestionId($questionId);

        $expectedResult = [
            ['id' => '1', 'question_id' => '123', 'title' => 'Option 1', 'chooser' => 3],
            ['id' => '2', 'question_id' => '123', 'title' => 'Option 2', 'chooser' => 5],
        ];
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetStatisticOptionByQuestionIdWithNoOptionsFound()
    {
        // Arrange
        $questionId = '456';

        $this->optionRepositoryMock
            ->expects($this->once())
            ->method('getAllOptionByQuestionId')
            ->with($questionId)
            ->willReturn([]);

        $result = $this->optionService->getStatisticOptionByQuestionId($questionId);

        $this->assertEquals([], $result);
    }

    public function testCreateOptionByQuestionIdSuccess()
    {
        // Arrange
        $questionId = '789';
        $options = [
            ['title' => 'Option 1'],
            ['title' => 'Option 2'],
        ];

            $this->optionRepositoryMock
            ->expects($this->exactly(2))
            ->method('createOption')
            ->willReturnCallback(function (OptionEntity $optionEntity) use ($questionId) {

                $this->assertEquals($questionId, $optionEntity->getQuestionId());
                $this->assertNotEmpty($optionEntity->getId());

                return true;
            });


        $this->optionService->createOptionByQuestionId($questionId, $options);
    }

}
