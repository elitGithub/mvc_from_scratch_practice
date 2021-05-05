<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\controllers\SiteController;
use App\Core\Application;

$app = new Application(dirname(__DIR__));

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);


$app->run();