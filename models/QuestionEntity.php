<?php

namespace app\models;

class QuestionEntity
{
    private string $id;
    private string $survey_id;
    private string $title;

    /**
     * @param string $id
     * @param string $survey_id
     * @param string $title
     */
    public function __construct(string $id, string $survey_id, string $title)
    {
        $this->id = $id;
        $this->survey_id = $survey_id;
        $this->title = $title;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getSurveyId(): string
    {
        return $this->survey_id;
    }

    public function setSurveyId(string $survey_id): void
    {
        $this->survey_id = $survey_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'survey_id' => $this->survey_id,
            'title' => $this->title
        ];
    }
}