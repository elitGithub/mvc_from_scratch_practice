<?php

namespace App\Core;

/**
 * Class Router
 * @package App\Core
 */
class Router
{

	protected array $routes = [];

	public function get($path, $callback)
	{
		$this->routes['get'][$path] = $callback;
	}

	public function post($path, $callback)
	{
		$this->routes['post'][$path] = $callback;
	}

	public function resolve()
	{
	}
}