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

//header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/json; charset=utf-8');
//header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
//header('Content-Type: text/plain');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit();
}

$request = new Request();
$response = new Response();
$router = new Router($request, $response, $container);
$app = new Application(dirname(__DIR__), $request, $response, $router);


$app->router->get('/api/v1/survey', [SurveyController::class, 'getAllSurvey']);
$app->router->get('/api/v1/survey/do-form/{id}', [SurveyController::class, 'getSurveyById']);
$app->router->get('/api/v1/survey/edit/{id}', [SurveyController::class, 'getSurveyById']);

$app->router->put('/api/v1/survey/edit', [SurveyController::class, 'updateSurvey']);

$app->router->post('/api/v1/survey/do-form', [SurveyController::class, 'updateRecordDoSurvey']);
$app->router->post('/api/v1/survey/create', [SurveyController::class, 'createNewSurvey']);

$app->router->post('/api/v1/register', [UserController::class, 'register']);
$app->router->post('/api/v1/login', [UserController::class, 'login']);

$app->router->delete('/api/v1/survey/{id}', [SurveyController::class, 'deleteSurvey']);


$app->run();