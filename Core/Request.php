<?php


namespace App\Core;


use JetBrains\PhpStorm\Pure;

class Request
{

	public function getPath()
	{
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$position = strpos($path, '?');
		if ($position === false) {
			return $path;
		}

		return substr($path, 0, $position);
	}

	public function method(): string
	{
		return strtolower($_SERVER['REQUEST_METHOD']);
	}

	#[Pure] public function isGet(): bool
	{
		return $this->method() === 'get';
	}

	#[Pure] public function isPost(): bool
	{
		return $this->method() === 'post';
	}

	public function getBody(): array
	{
		$body = [];

		if ($this->method() === 'get') {
			foreach ($_GET as $key => $value) {
				$body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}

		if ($this->method() === 'post') {
			if (empty($_POST)) {
				// In case of content type 'JSON', $_POST, $_REQUEST are not populated (yay PHP)
				$_POST = file_get_contents('php://input');
			}
			foreach ($_POST as $key => $value) {
				$body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}

		return $body;
	}
}