<?php
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\core\Request;
use app\core\Response;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Content-Type: text/plain');

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];
$request = new Request();
$response = new Response();
$router = new \app\core\Router($request, $response);
$db = new \app\core\Database($config['db']);
$app = new Application(dirname(__DIR__), $db, $request, $response, $router);

//$app->router->get('/', 'home');
//
$app->router->get('/contact', [SiteController::class, 'user']);
$app->router->post('/contact', [SiteController::class, 'contact']);

$app->router->post('/api/v1/login', [AuthController::class, 'login']);
$app->router->post('/api/v1/register', [AuthController::class, 'register']);

$app->run();