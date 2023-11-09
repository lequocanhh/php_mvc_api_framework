<?php

namespace app\models;

class SurveyEntity
{
    private string $id;
    private string $title;
    private string $description;
    private string $participant;
    private string $created_by;
    private string $created_at;

    /**
     * @param string $id
     * @param string $title
     * @param string $description
     * @param string $participant
     * @param string $created_by
     * @param string $created_at
     */
    public function __construct(string $id, string $title, string $description, string $participant, string $created_by, string $created_at)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->participant = $participant;
        $this->created_by = $created_by;
        $this->created_at = $created_at;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getParticipant(): string
    {
        return $this->participant;
    }

    public function setParticipant(string $participant): void
    {
        $this->participant = $participant;
    }

    public function getCreatedBy(): string
    {
        return $this->created_by;
    }

    public function setCreatedBy(string $created_by): void
    {
        $this->created_by = $created_by;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }



    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'participant' => $this->participant,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
        ];
    }

}