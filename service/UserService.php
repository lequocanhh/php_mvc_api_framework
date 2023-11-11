<?php

namespace app\service;

use app\dto\UserDto;
use app\dto\UserLoginDto;
use app\dto\UserResponseDto;
use app\exception\UserException;
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

    /**
     * @throws UserException
     */
    public function register(UserEntity $user, string $passwordConfirm): void
    {
        $userExist = $this->userRepository->findByEmail($user->getEmail());
        $userExist && throw UserException::userAlreadyExist();
        $user->getPassword() !== $passwordConfirm && throw UserException::invalidPasswordConfirm();

        $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
        $this->userRepository->create($user);
    }


    /**
     * @throws UserException
     */
    public function login(UserLoginDto $user): UserResponseDto
    {
        $userExist = $this->userRepository->findByEmail($user->getEmail());
        !$userExist &&  throw UserException::wrongInputLogin();
        $passwordMatch = password_verify($user->getPassword(), $userExist->getPassword());
        !$passwordMatch && throw UserException::wrongInputLogin();

        return new UserResponseDto($userExist->getId(), $userExist->getFirstname(), $userExist->getLastname(), $userExist->getEmail(), $userExist->getIsAdmin());
    }


}