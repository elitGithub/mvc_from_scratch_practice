<?php

namespace App\Core;

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

	public function __construct(string $rootPath, array $config)
	{
		static::$ROOT_DIR = $rootPath;
		$this->setApp($this);
		$this->request = new Request();
		$this->response = new Response();
		$this->router = new Router($this->request, $this->response);
		$this->db = new Database($config['db']);
	}

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