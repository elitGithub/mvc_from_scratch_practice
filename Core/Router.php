<?php

namespace App\Core;

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
		$method = $this->request->getMethod();
		$callback = $this->routes[$method][$path] ?? false;
		if (!$callback) {
			$this->response->setStatusCode(404);
			return 'Not found';
		}
		if (is_string($callback)) {
			return $this->renderView($callback);
		}

		return call_user_func($callback);
	}

	public function renderView(string $view): array|bool|string
	{
		$layoutContent = $this->layoutContent();
		$viewContent = $this->renderOnlyView($view);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	protected function layoutContent(): bool|string
	{
		ob_start();
		include_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'main.php';
		return ob_get_clean();
	}

	protected function renderOnlyView($view): bool|string
	{
		ob_start();
		include_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
		return ob_get_clean();
	}
}