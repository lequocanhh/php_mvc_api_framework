<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\exception\UserException;
use app\models\UserEntity;
use app\runtime\dto\UserLoginDto;
use app\service\JwtService;
use app\service\UserService;
use ErrorException;
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
        $passwordConfirm = $req['passwordConfirm'];
        $is_admin = 0;
        try {
            $user = new UserEntity(Uuid::uuid4(), $firstname, $lastname, $email, $password, $is_admin);
            $this->userService->register($user, $passwordConfirm);
            $response->render(200, 'Register successfully');
        }catch (UserException $error){
            $response->render(400, $error->getMessage());
        }
    }

    /**
     * @throws ErrorException
     */
    public function login(Request $request, Response $response): void
    {
        $req = $request->getBody();
        $email = $req['email'];
        $password = $req['password'];
        try {
            $userLogin = new UserLoginDto($email, $password);
            $userCreated = $this->userService->login($userLogin);
            $userResponse = $userCreated->toArray();
            $userResponse['token'] = JwtService::generateToken($userCreated);
            $response->render(200, 'Login successfully',$userResponse);
        }
        catch (UserException $error){
            $response->render(400, $error->getMessage());
        }
    }


}