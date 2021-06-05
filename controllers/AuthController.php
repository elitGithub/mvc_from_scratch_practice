<?php


namespace App\controllers;

use App\Core\Controller;
use App\Core\Request;
use App\models\RegisterModel;

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
		$registerModel = new RegisterModel();
		if ($request->isPost()) {
			$registerModel->loadDate($request->getBody());
			if ($registerModel->validate() && $registerModel->register()) {
				return 'Success';
			}
			return $this->render('register', [
				'model' => $registerModel,
			]);
		}

		$this->setLayout('auth');
		return $this->render('register', [
			'model' => $registerModel,
		]);
	}

}