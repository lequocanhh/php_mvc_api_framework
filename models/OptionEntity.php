<?php

namespace app\models;

class OptionEntity
{
    private string $id;
    private string $question_id;
    private string $title;
    private int $chooser;

    /**
     * @param string $id
     * @param string $question_id
     * @param string $title
     * @param int $chooser
     */
    public function __construct(string $id, string $question_id, string $title, int $chooser)
    {
        $this->id = $id;
        $this->question_id = $question_id;
        $this->title = $title;
        $this->chooser = $chooser;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getQuestionId(): string
    {
        return $this->question_id;
    }

    public function setQuestionId(string $question_id): void
    {
        $this->question_id = $question_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getChooser(): int
    {
        return $this->chooser;
    }

    public function setChooser(int $chooser): void
    {
        $this->chooser = $chooser;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'question_id' => $this->question_id,
            'title' => $this->title,
            'chooser' => $this->chooser
        ];
    }
}