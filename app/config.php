<?php


use app\core\Database;
use function DI\create;


$container = require __DIR__ . '/../app/bootstrap.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

return [
    Database::class => create(Database::class)->constructor($config['db'])
];