<?php

namespace App\Core;

use App\Core\Helpers\ResponseCodes;
/**
 * Class Router
 * @package App\Core
 */
class Router
{

	protected array $routes = [];

	/**
	 * Router constructor.
	 *
	 * @param  Request  $request
	 * @param  Response  $response
	 */
	public function __construct(public Request $request, public Response $response)
	{
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

	public function resolve()
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
		}
		return call_user_func($callback, $this->request);
	}

	public function renderView(string $view, $params = []): array|bool|string
	{
		$layoutContent = $this->layoutContent($params);
		$viewContent = $this->renderOnlyView($view, $params);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	protected function layoutContent($params): bool|string
	{
		foreach ($params as $key => $value) {
			$$key = $value;
		}
		ob_start();
		include_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'main.php';
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
}