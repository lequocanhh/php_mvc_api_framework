<?php

namespace app\service;

use ErrorException;
use Firebase\JWT\JWT;

class JwtService
{
    /**
     * @throws ErrorException
     */
    public static function generateToken($user): string
    {
        try {
            $key = $_ENV['SECRET_KEY'] ?? "";
            $payload = [
                "iat" => time(),
                "exp" => time() + (60 * 60),
                "user_id" => $user->getId(),
                "is_admin" => $user->getIsAdmin()
            ];
        }catch (ErrorException $e){
            throw new \ErrorException("cannot generate token .$e");
        }

        return JWT::encode($payload, $key, "HS256");
    }
}