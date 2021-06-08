<?php


namespace App\controllers;

use App\Core\Controller;
use App\Core\Request;
use App\models\User;

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
		$user = new User();
		if ($request->isPost()) {
			$user->loadData($request->getBody());
			if ($user->validate() && $user->save()) {
				echo 'Success';
			}
			return $this->render('register', [
				'model' => $user,
			]);
		}
		return $this->render('register', [
			'model' => $user,
		]);
	}

}