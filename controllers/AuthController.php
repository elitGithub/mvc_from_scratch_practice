<?php


namespace App\controllers;

use App\Core\Controller;
use App\Core\Request;

/**
 * Class AuthController
 * @package App\controllers
 */
class AuthController extends Controller
{

	/**
	 * @return bool|array|string
	 */
	public function login(): bool|array|string
	{
		$this->setLayout('auth');
		return $this->render('login');
	}

	/**
	 * @param  Request  $request
	 *
	 * @return bool|array|string
	 */
	public function register(Request $request): bool|array|string
	{
		$this->setLayout('auth');
		if ($request->isPost()) {
			return 'Handle submitted data';
		}

		return $this->render('register');
	}

}