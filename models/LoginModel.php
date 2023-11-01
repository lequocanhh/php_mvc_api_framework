<?php
namespace app\models;

use app\core\DbModel;
use app\core\Model;

class LoginModel extends DbModel
{
    public string $email = '';
    public string $password = '';

    public function login(): array
    {
         $user = parent::findOne(['email' => $this->email]);
         $filteredData = [];
         if($user && password_verify($this->password, $user->password)){
            foreach ($user as $field => $value){
                if($field !== "password"){
                    $filteredData[$field] = $value;
                }
            }
            return $filteredData;
         }
         return [];
    }


    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['email', 'password'];
    }
}