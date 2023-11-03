<?php

use app\models\repository\UserRepository;
use app\repository\UserRepositoryInterface;
use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/config.php');
try {
    $container = $containerBuilder->build();
    return $container;
} catch (Exception $e) {
    echo $e;
    die;
}

