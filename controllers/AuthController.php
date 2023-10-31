<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\LoginModel;
use app\models\UserModel;


class AuthController
{

    public function register(Request $request)
    {
        $userModel = new UserModel();
        $userModel->loadData($request->getBody());
        if($userModel->validate() && $userModel->save()){
            Application::$app->session->setFlash('success', 'Thank for register');
            return 'register success';
        }else{
            return 'register failed';
        }
    }

    public function login(Request $request)
    {

        $loginModel = new LoginModel();
        $loginModel->loadData($request->getBody());
        if($loginModel->validate() && $loginModel->login()){

            return 'login success';
        }
    }

}