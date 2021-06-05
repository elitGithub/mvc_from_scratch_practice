<?php


namespace App\controllers;

use App\Core\Controller;
use App\Core\Request;

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
			'pageTitle' => 'Contact',
		];
		return $this->render('contact', $params);
	}

	public static function handleContact(Request $request): string
	{
		$params = [
			'pageTitle' => 'Contact',
		];
		$body = $request->getBody();

		return 'Handling submitted data';
	}
}