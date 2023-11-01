<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\models\LoginModel;
use app\models\RegisterModel;


class AuthController
{
    public const SUCCESS = true;
    public const FAILED = true;

    public function __construct()
    {

    }

    public function register(Request $request, Response $response): void
    {
        $registerModel = new RegisterModel();
        $registerModel->loadData($request->getBody());
        if($registerModel->validate() && $registerModel->save()){
            $response->render(200, self::SUCCESS,'Register successfully');
        }else{
            $response->render(404, self::FAILED,'Register failed');
        }
    }

    public function login(Request $request, Response $response): void
    {
        $loginModel = new LoginModel();
        $loginModel->loadData($request->getBody());
        $user = $loginModel->login();
        if($loginModel->validate() && $user){
            $response->render(200, self::SUCCESS, 'Login successfully', $user);
        }else{
            $response->render(404, self::FAILED,'Login failed');
        }
    }

}