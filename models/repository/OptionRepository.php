<?php

namespace app\models\repository;

use app\core\Database;
use app\models\OptionEntity;
use app\repository\IOptionRepository;

class OptionRepository extends BaseRepository implements IOptionRepository
{
    public function __construct(Database $db)
    {
        $this->table = 'options';
        $this->db = $db;
    }

    public function createOption(OptionEntity $option): void
    {
        parent::save($option);
    }
}