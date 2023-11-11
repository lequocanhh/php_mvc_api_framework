<?php

namespace app\exception;

class UserException extends \Exception
{
    public static function invalidStringLength(): UserException
    {
        return new static("Invalid first name/last name length!");
    }

    public static function invalidEmail(): UserException
    {
        return new static("The email is not valid!");
    }

    public static function inValidPassword(): UserException
    {
        return new static("Password must contain at least 8 characters, 1 uppercase, 1 lowercase, 1 number and 1 special character!");
    }

    public static function invalidPasswordConfirm(): UserException
    {
        return new static("Password confirm must match!");
    }

    public static function userAlreadyExist(): UserException
    {
        return new static("The user already exists!");
    }

    public static function wrongInputLogin(): UserException
    {
        return new static("The email or password are not exist, please try again!");
    }


}