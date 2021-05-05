<?php


namespace App\Core;


class Controller
{

	public function render($view, $params = []): bool|array|string
	{
		return Application::$app->router->renderView($view, $params);
	}
}