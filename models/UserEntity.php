<?php

namespace app\models;

use Ramsey\Uuid\Uuid;

class UserEntity
{
   private string $id;
   private string $firstname;
   private string $lastname;
   private string $email;
   private string $password;
   private bool $is_admin;

    /**
     * @param string $id
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @param bool $is_admin
     */
    public function __construct(string $id, string $firstname, string $lastname, string $email, string $password, bool $is_admin)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
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

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
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