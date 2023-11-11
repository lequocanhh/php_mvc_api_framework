<?php

namespace app\dto;
class OptionDto{
    private string $id;
    private string $title;

    /**
     * @param string $id
     * @param string $title
     */
    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }


}