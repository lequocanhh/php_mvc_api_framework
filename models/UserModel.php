<?php

namespace app\models;

use app\core\DbModel;

class UserModel extends DbModel
{
    public string $firstname = '';
    public string $lastname = '';
    public string $username = '';
    public string $password = '';
    public string $passwordConfirm = '';


    public function tableName(): string
    {
        return 'users';
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }


    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'username' => [self::RULE_REQUIRED,[
                //it will be unique in the database userModel class
                self::RULE_UNIQUE, 'class' => self::class, 'attribute' => 'username'
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'passwordConfirm' => [[self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function attributes():  array
    {
        return ['firstname', 'lastname', 'username', 'password'];
    }
}