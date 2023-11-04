<?php

namespace app\models\repository;

use app\core\Application;
use app\core\Database;
use app\dto\UserDto;
use app\dto\UserLoginDto;
use app\helper\Helper;
use app\models\UserEntity;
use app\repository\IUserRepository;
use DI\NotFoundException;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(Database $db)
    {
        $this->table = 'users';
        $this->db = $db;
    }

    public function findByEmail($email): ?UserEntity
    {
        $user = parent::find('email', $email);
        return $user ? new UserEntity($user->id, $user->firstname, $user->lastname, $user->email, $user->password, $user->is_admin) : null;
    }

    public function create(UserEntity $user): void
    {
        parent::save($user);
    }


    

}