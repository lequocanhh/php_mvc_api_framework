<?php

namespace app\repository;

use app\models\OptionEntity;

interface IOptionRepository
{
    public function createOption(OptionEntity $option): void;
}