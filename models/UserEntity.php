<?php

namespace app\models;

use app\exception\UserException;

class UserEntity
{
    public const MAX_NAME_LENGTH = 10;
    public const MIN_NAME_LENGTH = 1;
    public const MIN_PASSWORD_LENGTH = 8;

   private string $id;
   private string $firstname;
   private string $lastname;
   private string $email;
   private string $password;
   private string $is_admin;

    /**
     * @param string $id
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @param string $is_admin
     * @throws UserException
     */
    public function __construct(string $id, string $firstname, string $lastname, string $email, string $password, string $is_admin)
    {
        $this->id = $id;
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->is_admin = $is_admin;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @throws UserException
     */
    public function setFirstname(string $firstname): void
    {
        if(strlen($firstname) > self::MAX_NAME_LENGTH || strlen($firstname) <= self::MIN_NAME_LENGTH){
            throw UserException::InvalidStringLength();
        }
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @throws UserException
     */
    public function setLastname(string $lastname): void
    {
        if(strlen($lastname) > self::MAX_NAME_LENGTH){
            throw UserException::invalidStringLength();
        }
        $this->lastname = $lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @throws UserException
     */
    public function setEmail(string $email): void
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw UserException::invalidEmail();
        }
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @throws UserException
     */
    public function setPassword(string $password): void
    {
        if(strlen($password) < self::MIN_PASSWORD_LENGTH){
            throw UserException::inValidPassword();
        }
        $this->password = $password;
    }


    public function getIsAdmin(): bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(string $is_admin): void
    {
        $this->is_admin = $is_admin;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password,
            'is_admin' => $this->is_admin
        ];
    }


}