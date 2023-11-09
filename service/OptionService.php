<?php

namespace app\service;

use app\models\OptionEntity;
use app\models\repository\OptionRepository;
use http\Exception\RuntimeException;

class OptionService
{
    private OptionRepository $optionRepository;
    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function getAllOptionByQuestionId($id): array
    {
        $options = [];
        $optionList = $this->optionRepository->getAllOptionByQuestionId($id);
        foreach ($optionList as $option) {
            $options[] = [
                'id' => $option['id'],
                'title' => $option['title']
            ];
        }
        return $options;
    }

    public function createOption(OptionEntity $option): void
    {
        $this->optionRepository->createOption($option);
    }

    public function updateOptionRecord($id): bool
    {
       $isUpdated = $this->optionRepository->updateOptionRecord($id);
       return $isUpdated ? true : throw new \RuntimeException("Updated chooser failed");
    }
}