<?php

namespace models\repository;

use app\core\Database;
use app\exception\UserException;
use app\models\repository\UserRepository;
use app\models\UserEntity;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{

    private UserRepository $userRepository;
    private $mockDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockDatabase = $this->createMock(Database::class);
        $this->userRepository = new UserRepository($this->mockDatabase);
    }

    /**
     * @throws UserException
     */
    public function testFindByEmailSuccess()
    {
        $email = 'lequocah@gmail.com';
        $userData = [
            'id' => 1,
            'firstname' => 'Quoc',
            'lastname' => 'Anh',
            'email' => $email,
            'password' => 'hashed_password',
            'is_admin' => false,
        ];

        $this->mockDatabase
            ->expects($this->once())
            ->method('find')
            ->with('email', $email)
            ->willReturn((object)$userData);

        $result = $this->userRepository->findByEmail($email);

        $this->assertInstanceOf(UserEntity::class, $result);
        $this->assertEquals($userData['id'], $result->getId());
        $this->assertEquals($userData['firstname'], $result->getFirstname());
        $this->assertEquals($userData['lastname'], $result->getLastname());
        $this->assertEquals($userData['email'], $result->getEmail());
        $this->assertEquals($userData['password'], $result->getPassword());
        $this->assertEquals($userData['is_admin'], $result->getIsAdmin());

    }
}
