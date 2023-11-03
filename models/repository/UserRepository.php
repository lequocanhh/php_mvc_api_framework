<?php

namespace app\models\repository;

use app\core\Application;
use app\core\Database;
use app\dto\UserDto;
use app\dto\UserLoginDto;
use app\helper\Helper;
use app\models\UserEntity;
use app\repository\UserRepositoryInterface;
use DI\NotFoundException;

class UserRepository implements UserRepositoryInterface
{
    private Database $db;
    private string $table = 'users';
    public function __construct(Database $db)
    {
        $this->db = $db;
    }



    public function findByEmail($email): ?UserEntity
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetchObject();
        return $user ? new UserEntity($user->id, $user->firstname, $user->lastname, $user->email, $user->password, $user->is_admin) : null;
    }
    public function save(UserEntity $user): void{
        $id = $user->getId();
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $is_admin = $user->getIsAdmin();
        $params = array_map(fn($attr) => ":$attr",$user->toArray());

            $stmt = $this->db->prepare("INSERT INTO $this->table 
            (".implode(',', $user->toArray()).")
            VALUES(".implode(',', $params).")");
            foreach ($user->toArray() as $attribute) {
                $stmt->bindValue(":$attribute",  ${$attribute});
            }
            $stmt->execute();
    }

}