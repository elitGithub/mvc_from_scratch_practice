<?php


namespace App\models;

use App\Core\DbModel;

/**
 * Class RegisterModel
 * @package App\models
 */
class User extends DbModel
{
	public string $first_name = '';
	public string $last_name = '';
	public string $email = '';
	public string $password = '';
	public string $confirm_password = '';

	public function register()
	{
		echo 'creating new user';
		return true;
	}

	public function rules(): array
	{
		return [
			'first_name'       => [static::RULE_REQUIRED],
			'last_name'        => [static::RULE_REQUIRED],
			'email'            => [static::RULE_REQUIRED, static::RULE_EMAIL],
			'password'         => [
				static::RULE_REQUIRED,
				[static::RULE_MIN, static::RULE_MIN => 8],
				[static::RULE_MAX, static::RULE_MAX => 24],
			],
			'confirm_password' => [static::RULE_REQUIRED, [static::RULE_MATCH, static::RULE_MATCH => 'password']],
		];
	}

	public function tableName(): string
	{
		return 'users';
	}
}