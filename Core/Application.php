<?php

namespace App\Core;

/**
 * Class Application
 * @package App\Core
 */
class Application
{
	public static string $ROOT_DIR;
	public Router $router;
	public Request $request;
	public Response $response;
	public static Application $app;

	public function __construct($rootPath)
	{
		static::$ROOT_DIR = $rootPath;
		static::$app = $this;
		$this->request = new Request();
		$this->response = new Response();
		$this->router = new Router($this->request, $this->response);
	}

	public function run()
	{
		echo $this->router->resolve();
	}
}