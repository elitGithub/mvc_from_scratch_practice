<?php


namespace App\Core;


class View
{
	public string $title = '';

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
	public function layoutContent($params): bool|string
	{
		$layout = Application::$app->layout;
		foreach ($params as $key => $value) {
			$$key = $value;
		}
		if (Application::$app->getController()) {
			$layout = Application::$app->getController()->layout;
		}
		ob_start();
		include_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $layout . '.php';
		return ob_get_clean();
	}

	/**
	 * @param $view
	 * @param $params
	 *
	 * @return bool|string
	 */
	public function renderOnlyView($view, $params): bool|string
	{
		foreach ($params as $key => $value) {
			$$key = $value;
		}

		ob_start();
		include_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
		return ob_get_clean();
	}

}