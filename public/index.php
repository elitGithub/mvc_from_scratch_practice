<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Core\Application;

$app = new Application();

$app->router->get('/', function () {
	return 'Hello world';
});

$app->router->get('/contact', function () {
	return 'Contact';
});

$app->run();