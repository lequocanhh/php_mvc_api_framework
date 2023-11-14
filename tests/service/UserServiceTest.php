<?php

namespace service;

use app\exception\UserException;
use app\models\repository\UserRepository;
use app\models\UserEntity;
use app\runtime\dto\UserLoginDto;
use app\runtime\dto\UserResponseDto;
use app\service\UserService;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserServiceTest extends TestCase
{
    private $userRepositoryMock;
    private UserService $userService;
    public function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->userService = new UserService($this->userRepositoryMock);
    }

    /**
     * @throws UserException
     */
    public function testRegisterSuccess(): void
    {
        $user = new UserEntity(Uuid::uuid4(), "quoc", "anh", "lequocanh@gmail.com", "password", true);
        $this->userRepositoryMock
            ->expects($this->once())
            ->method("findByEmail")
            ->with($user->getEmail())
            ->willReturn(null);
        $this->userRepositoryMock
            ->expects($this->once())
            ->method("create")
            ->with($user);

            $this->userService->register($user, 'password');
    }

    /**
     * @throws UserException
     */
    public function testRegisterUserAlreadyExist(): void
    {
        $user = new UserEntity(Uuid::uuid4(), "quoc", "anh", "lequocanh@gmail.com", "password", true);
        $this->userRepositoryMock
            ->expects($this->once())
            ->method("findByEmail")
            ->with($user->getEmail())
            ->willReturn($user);

        $this->userRepositoryMock
            ->expects($this->never())
            ->method("create");

        $this->expectException(UserException::class);
        $this->userService->register($user, 'password');
    }

    /**
     * @throws UserException
     */
    public function testRegisterInvalidPasswordConfirm(): void
    {
        $this->expectException(UserException::class);

        $user = new UserEntity(Uuid::uuid4(), "quoc", "anh", "lequocanh@gmail.com", "password", true);
        $this->userRepositoryMock
            ->expects($this->once())
            ->method("findByEmail")
            ->with($user->getEmail())
            ->willReturn($user);

        $this->userRepositoryMock
            ->expects($this->never())
            ->method("create");

        $this->userService->register($user, 'wrong-password');
    }


    /**
     * @throws UserException
     */
    public function testLoginSuccess(): void
    {
        $userLoginDto = new UserLoginDto("lequocanh@gmail.com", "password");
        $userEntity = new UserEntity(Uuid::uuid4(), "quoc", "anh", "lequocanh@gmail.com", password_hash('password', PASSWORD_DEFAULT), true);

        $this->userRepositoryMock
            ->expects($this->once())
            ->method("findByEmail")
            ->with($userLoginDto->getEmail())
            ->willReturn($userEntity);

        $responseDto = $this->userService->login($userLoginDto);
        $this->assertInstanceOf(UserResponseDto::class, $responseDto);
    }

    /**
     * @throws UserException
     */
    public function testLoginInvalidUser(): void
    {
        $userLoginDto = new UserLoginDto("invalid@gmail.com", "password");

        $this->userRepositoryMock
            ->expects($this->once())
            ->method("findByEmail")
            ->with($userLoginDto->getEmail())
            ->willReturn(null);

        $this->expectException(UserException::class);

        $this->userService->login($userLoginDto);
    }

    /**
     * @throws UserException
     */
    public function testLoginInvalidPassword(): void
    {
        $userLoginDto = new UserLoginDto("lequocanh@gmail.com", "wrong-password");

        $userEntity = new UserEntity(Uuid::uuid4(), "quoc", "anh", "lequocanh@gmail.com", password_hash('password', PASSWORD_DEFAULT), true);
        $this->userRepositoryMock
            ->expects($this->once())
            ->method("findByEmail")
            ->with($userLoginDto->getEmail())
            ->willReturn($userEntity);

        $this->expectException(UserException::class);

        $this->userService->login($userLoginDto);
    }


}
