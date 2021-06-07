<?php

namespace App\Core;

use App\controllers\AuthController;
use App\controllers\SiteController;
use App\Core\Helpers\ResponseCodes;
use JetBrains\PhpStorm\Pure;

/**
 * Class Router
 * @package App\Core
 */
class Router
{
	protected Application $app;

	/**
	 * @var array
	 */
	protected array $routes = [];

	/**
	 * Router constructor.
	 *
	 * @param  Request  $request
	 * @param  Response  $response
	 */
	#[Pure] public function __construct(public Request $request, public Response $response)
	{
		$this->app = Application::getApp();
	}

	/**
	 * @param $path
	 * @param $callback
	 */
	public function get($path, $callback)
	{
		$this->routes['get'][$path] = $callback;
	}

	/**
	 * @param $path
	 * @param $callback
	 */
	public function post($path, $callback)
	{
		$this->routes['post'][$path] = $callback;
	}

	/**
	 * @return mixed
	 */
	public function resolve(): mixed
	{
		$path = $this->request->getPath();
		$method = $this->request->method();
		$callback = $this->routes[$method][$path] ?? false;

		if (!$callback) {
			$this->response->setStatusCode(ResponseCodes::HTTP_NOT_FOUND);
			return $this->renderView(ResponseCodes::HTTP_NOT_FOUND);
		}
		if (is_string($callback)) {
			return $this->renderView($callback);
		}

		if (is_array($callback)) {
			$callback[0] = new $callback[0]();
			$this->app->setController($callback[0]);
		}
		return call_user_func($callback, $this->request);
	}

	/**
	 * @param  string  $view
	 * @param  array  $params
	 *
	 * @return array|bool|string
	 */
	public function renderView(string $view, array $params = []): array|bool|string
	{
		$layoutContent = $this->layoutContent($params);
		$viewContent = $this->renderOnlyView($view, $params);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	/**
	 * @param $params
	 *
	 * @return bool|string
	 */
	protected function layoutContent($params): bool|string
	{
		foreach ($params as $key => $value) {
			$$key = $value;
		}
		$layout = $this->app->getController()->layout;
		ob_start();
		include_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $layout . '.php';
		return ob_get_clean();
	}

	protected function renderOnlyView($view, $params): bool|string
	{
		foreach ($params as $key => $value) {
			$$key = $value;
		}

		ob_start();
		include_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
		return ob_get_clean();
	}

	/**
	 * All your base are belong to us
	 * Register the application routes here
	 * @TODO: Maybe make this more diverse/use separate files, as in a larger application, this thing will become a monster.
	 */
	public function registerRoutes()
	{
		$this->get('/', [SiteController::class, 'home']);

		$this->get('/contact', [SiteController::class, 'contact']);
		$this->post('/contact', [SiteController::class, 'handleContact']);

		$this->get('/login', [AuthController::class, 'login']);
		$this->post('/login', [AuthController::class, 'login']);

		$this->get('/register', [AuthController::class, 'register']);
		$this->post('/register', [AuthController::class, 'register']);
	}
}