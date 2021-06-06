<?php

use App\Core\Application;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$config = [
	'db' => [
		'dsn'      => $_ENV['DB_DSN'],
		'user'     => $_ENV['DB_USER'],
		'password' => $_ENV['DB_PASSWORD'],
	],
];

$app = new Application(__DIR__, $config);
$app->db->applyMigrations();