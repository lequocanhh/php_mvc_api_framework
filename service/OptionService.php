<?php

namespace app\service;

use app\models\OptionEntity;
use app\models\repository\OptionRepository;

class OptionService
{
    private OptionRepository $optionRepository;
    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function createOption(OptionEntity $option): void
    {
        $this->optionRepository->createOption($option);
    }
}