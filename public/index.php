<?php

use App\Core\Application;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$app = new Application(dirname(__DIR__));
$app->router->registerRoutes();

$app->make();

$app->run();