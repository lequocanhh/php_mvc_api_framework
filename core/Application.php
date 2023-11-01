<?php

namespace app\core;
class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public static Application $app;
    public static string $ROOT_DIR;
    public function __construct($rootDir, Database $db, Request $request, Response $response, Router $router)
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootDir;
        $this->request = $request;
        $this->response = $response;
        $this->router = $router;
        $this->db = $db;
    }

    public function run()
    {
       echo $this->router->resolve();
    }
}