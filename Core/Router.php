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
	 */
	public function __construct(public Request $request)
	{
	}

	/**
	 * @param $path
	 * @param  callable  $callback
	 */
	public function get($path, callable $callback)
	{
		$this->routes['get'][$path] = $callback;
	}

	/**
	 * @param $path
	 * @param  callable  $callback
	 */
	public function post($path, callable $callback)
	{
		$this->routes['post'][$path] = $callback;
	}

	public function resolve()
	{
		$path = $this->request->getPath();
		$method = $this->request->getMethod();
		$callback = $this->routes[$method][$path] ?? false;
		if (!$callback) {
			echo 'Not found';
			exit;
		}
		echo call_user_func($callback);
	}
}