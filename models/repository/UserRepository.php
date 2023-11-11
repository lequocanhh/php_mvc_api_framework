<?php

namespace app\models\repository;

use app\core\Application;
use app\core\Database;
use app\dto\UserDto;
use app\dto\UserLoginDto;
use app\exception\UserException;
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

    /**
     * @throws UserException
     */
    public function findByEmail($email): ?UserEntity
    {
        $userExist = parent::find('email', $email);
        if(!$userExist){
            return null;
        }
        return new UserEntity($userExist->id, $userExist->firstname, $userExist->lastname, $userExist->email, $userExist->password, $userExist->is_admin);
    }

    public function create(UserEntity $user): void
    {
        parent::save($user);
    }


    

}