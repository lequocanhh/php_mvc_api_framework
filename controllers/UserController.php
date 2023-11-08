<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\dto\UserLoginDto;
use app\models\UserEntity;
use app\service\JwtService;
use app\service\UserService;
use Exception;
use Ramsey\Uuid\Uuid;


class UserController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function register(Request $request, Response $response): void
    {
        $req = $request->getBody();
        $firstname = $req['firstname'];
        $lastname = $req['lastname'];
        $email = $req['email'];
        $password = $req['password'];
        $is_admin = $req['is_admin'];
        try {
            $user = new UserEntity(Uuid::uuid4(), $firstname, $lastname, $email, $password, $is_admin);
            $userCreated = $this->userService->register($user);
            if($userCreated){
                $response->render(200, 'Register successfully');
            }else{
                $response->render(400, "Register failed");
            }
        }catch (Exception $error){
            throw new \Error("Cannot save user to db .$error");
        }

    }

    /**
     * @throws \ErrorException
     */
    public function login(Request $request, Response $response): void
    {
        $req = $request->getBody();
            $userLogin = new UserLoginDto($req['email'], $req['password']);
            $userCreated = $this->userService->login($userLogin);
            if($userCreated){
                $userResponse = $userCreated->toArray();
                $userResponse['token'] = JwtService::generateToken($userCreated);
                $response->render(200, 'Login successfully',$userResponse);
            }else{
                $response->render(400, 'Login failed');
            }
    }


}