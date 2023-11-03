<?php

namespace app\repository;

use app\dto\UserDto;
use app\dto\UserLoginDto;
use app\models\UserEntity;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?UserEntity;
    public function save(UserEntity $user): void;

}