<?php

use App\Core\Application;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$config = [
	'db' => [
		'dsn'      => $_ENV['DB_DSN'],
		'user'     => $_ENV['DB_USER'],
		'password' => $_ENV['DB_PASSWORD'],
	],
];

$app = new Application(dirname(__DIR__), $config);
$app->router->registerRoutes();

$app->run();