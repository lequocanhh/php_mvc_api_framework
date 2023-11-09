<?php

namespace app\repository;

use app\dto\UserDto;
use app\dto\UserLoginDto;
use app\models\UserEntity;

interface IUserRepository
{
    public function findByEmail(string $email): ?UserEntity;
    public function create(UserEntity $user): void;

}