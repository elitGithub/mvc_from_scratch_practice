<?php

namespace App\Core;

use JetBrains\PhpStorm\Pure;

/**
 * Class Application
 * @package App\Core
 */
class Application
{
	public Router $router;
	public Request $request;

	#[Pure] public function __construct()
	{
		$this->request = new Request();
		$this->router = new Router($this->request);
	}

	public function run()
	{
		$this->router->resolve();
	}
}