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

	public function login()
	{
		return $this->render('login');
	}

	public function register(Request $request)
	{
		if ($request->isPost()) {
			return 'Handle submitted data';
		}

		return $this->render('register');
	}

}