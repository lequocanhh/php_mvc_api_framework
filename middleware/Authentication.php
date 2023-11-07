<?php

namespace app\middleware;

use app\core\Request;
use app\core\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authentication
{
    public static function tokenValidation(Request $req, Response $res): bool
    {
        $header = apache_request_headers();
        $token = $header['Authorization'] ?? null;
        if (!$token) {
            $res->render(401, "Unauthorized");
            exit();
        }
        $token = str_replace("Bearer ", '', $token);

        try {
            $decode = JWT::decode($token, new Key($_ENV['SECRET_KEY'], 'HS256'));
            $decode = json_decode(json_encode($decode), true);
            $req->setBody(['user_id' => $decode['user_id'], 'is_admin' => $decode['is_admin']]);
            return true;
        } catch (\Exception $e) {
            $res->render(401, "Unauthorized");
            exit();
        }
    }

    public static function adminTokenValidation(Request $req, Response $res): bool
    {
        self::tokenValidation($req, $res);
        $req = $req->toArray();
        if($req['is_admin']) return $req['is_admin'];
        $res->render(401, "You have not permission");
        return false;
    }


}