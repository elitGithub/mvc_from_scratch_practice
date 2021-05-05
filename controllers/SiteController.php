<?php


namespace App\controllers;

use App\Core\Controller;

/**
 * Class SiteController
 * @package App\controllers
 */
class SiteController extends Controller
{
	public function home(): bool|array|string
	{
		$params = [
			'name'      => 'Eli',
			'pageTitle' => 'My super awesome app',
		];

		return $this->render('home', $params);
	}

	public function contact(): bool|array|string
	{
		$params = [
			'pageTitle' => 'contact',
		];
		return $this->render('contact', $params);
	}

	public static function handleContact(): string
	{
		$params = [
			'pageTitle' => 'contact',
		];
		return 'Handling submitted data';
	}
}