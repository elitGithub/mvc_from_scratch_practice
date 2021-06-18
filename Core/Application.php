<?php

namespace App\Core;

use Dotenv\Dotenv;

/**
 * Class Application
 * @package App\Core
 */
class Application
{
	public static string $ROOT_DIR;
	public static Application $app;
	public Controller $controller;
	public Database $db;
	public Router $router;
	public Request $request;
	public Response $response;
	public Session $session;

	public function __construct(string $rootPath)
	{
		static::$ROOT_DIR = $rootPath;
		$this->setApp($this);
		$this->request = new Request();
		$this->response = new Response();
		$this->router = new Router($this->request, $this->response);
		$this->session = new Session();
	}

	/**
	 * Make the app - should load the config (maybe load some other stuff?)
	 * For now - load the DB.
	 */
	public function bootstrap()
	{
		$dotenv = Dotenv::createImmutable(static::$ROOT_DIR);
		$dotenv->load();

		$config = [
			'db' => [
				'dsn'      => $_ENV['DB_DSN'],
				'user'     => $_ENV['DB_USER'],
				'password' => $_ENV['DB_PASSWORD'],
			],
		];

		$this->db = new Database($config['db']);
	}

	/**
	 * Run the application - resolve the routing.
	 */
	public function run()
	{
		echo $this->router->resolve();
	}

	/**
	 * @return Controller
	 */
	public function getController(): Controller
	{
		return $this->controller;
	}

	/**
	 * @param  Controller  $controller
	 */
	public function setController(Controller $controller): void
	{
		$this->controller = $controller;
	}

	/**
	 * @return Application
	 */
	public static function getApp(): Application
	{
		return static::$app;
	}

	/**
	 * @param  Application  $app
	 */
	public static function setApp(Application $app): void
	{
		static::$app = $app;
	}
}