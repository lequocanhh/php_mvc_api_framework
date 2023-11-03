<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;
use app\dto\UserDto;
use app\dto\UserLoginDto;
use app\models\LoginModel;
use app\models\UserEntity;
use app\service\JwtService;
use app\service\UserService;
use Exception;
use Ramsey\Uuid\Uuid;

// layer architecture: controller --> service --> repository --> DB

class UserController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    // Global error handler
//    public function register(Request $request, Response $response): void
//    {
//        try {
//           // $userDto = new UserDto($request->id, $request->mail, ....);
//            $this->userService->register($request->getBody());
//            $response->render(200, self::SUCCESS, 'Register successfully');
//        } catch ($error) {
//            $response->render(400, self::SUCCESS, 'Error');
//        }
//
//
//
//        $registerModel = new RegisterModel();
//        $registerModel->loadData($request->getBody());
//        if ($registerModel->validate() && $registerModel->save()) {
//            $response->render(200, self::SUCCESS, 'Register successfully');
//        } else {
//            $response->render(404, self::FAILED, 'Register failed');
//        }
//    }
//
//    // UserService
//    public function registerService() { // S trong SOLID
//        // check user exist
//        $user = $this->userRepositoryInterface->getByEmail($userDto->getMail());
//        if ($user) {
//            throw new UserExistException('This user is exist in DB, please try again');
//        }
//
//        // save database
//        $userEntity = new UserEntity($userDto->getMail(), $userDto->getName());
//        $this->userRepositoryInterface->save($userEntity);
//    }
//
//    // UserRepository
//    public function save(UserEntity $user)
//    {
//        $query = Insert into.....
//        // save
//    }
//
//    public function getByEmail(String $email)
//    {
//        // Handle SQL injection
//        // Select * from table_user where email = $email
//        // save
//    }

    public function register(Request $request, Response $response): void
    {
        $req = $request->getBody();
        $firstname = $req['firstname'];
        $lastname = $req['lastname'];
        $email = $req['email'];
        $password = $req['password'];
        $is_admin = $req['is_admin'];
        try {
            $userDto = new UserEntity(Uuid::uuid4(), $firstname, $lastname, $email, $password, $is_admin);
            $user = $this->userService->register($userDto);
            if($user){
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