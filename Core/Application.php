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

	#[Pure] public function __construct()
	{
		$this->router = new Router();
	}

	public function run()
	{
		$this->router->resolve();
	}
}