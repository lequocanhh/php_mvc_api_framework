<?php

namespace app\service;

use app\dto\UserDto;
use app\dto\UserLoginDto;
use app\dto\UserResponseDto;
use app\models\repository\UserRepository;
use app\models\UserEntity;
use app\repository\IUserRepository;
use DI\NotFoundException;
use ErrorException;

class UserService
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserEntity $user): bool
    {
        $userExist = $this->userRepository->findByEmail($user->getEmail());
        if($userExist){
            return false;
        }
        $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
        $this->userRepository->create($user);
        return true;
    }


    public function login(UserLoginDto $user): ?UserResponseDto
    {
        $userExist = $this->userRepository->findByEmail($user->getEmail());
        if($userExist){
            $passwordMatch = password_verify($user->getPassword(), $userExist->getPassword());

            if(!empty($userExist) && $passwordMatch){
                return new UserResponseDto($userExist->getId(), $userExist->getFirstname(), $userExist->getLastname(), $userExist->getEmail(), $userExist->getIsAdmin());
            }
        }
        return null;
    }


}