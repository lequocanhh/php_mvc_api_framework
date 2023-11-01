<?php
use app\core\Application;
use app\core\Request;
use app\core\Response;

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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
$app = new Application(__DIR__, $db, $request, $response, $router);


$app->db->applyMigrations();
