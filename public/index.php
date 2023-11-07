<?php

use app\controllers\SurveyController;
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\UserController;
use app\core\Request;
use app\core\Response;
use app\core\Router;
use app\middleware\Authentication;

require_once __DIR__ . '/../vendor/autoload.php';
$container = require dirname(__DIR__).'/app/bootstrap.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Content-Type: text/plain');


$request = new Request();
$response = new Response();
$router = new Router($request, $response, $container);
$app = new Application(dirname(__DIR__), $request, $response, $router);


$app->router->get('/api/v1/survey', [SurveyController::class, 'getAllSurvey']);
$app->router->get('/api/v1/survey/{id}', [SurveyController::class, 'getSurveyById']);

$app->router->post('/api/v1/survey/create', [SurveyController::class, 'createNewSurvey'], [Authentication::class, 'adminTokenValidation']);

$app->router->post('/api/v1/register', [UserController::class, 'register']);
$app->router->post('/api/v1/login', [UserController::class, 'login']);


$app->run();