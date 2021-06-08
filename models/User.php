<?php


namespace App\models;

use App\Core\DbModel;

/**
 * Class RegisterModel
 * @package App\models
 */
class User extends DbModel
{
	public const STATUS_INACTIVE = 0;
	public const STATUS_ACTIVE = 1;
	public const STATUS_DELETED = 2;
	public string $first_name = '';
	public string $last_name = '';
	public string $email = '';
	public string $password = '';
	public int $status = self::STATUS_INACTIVE;
	public string $confirm_password = '';

	public function save(): bool
	{
		$this->password = password_hash($this->password, PASSWORD_DEFAULT);
		$this->status = static::STATUS_ACTIVE;
		return parent::save();
	}

	public function rules(): array
	{
		return [
			'first_name'       => [static::RULE_REQUIRED],
			'last_name'        => [static::RULE_REQUIRED],
			'email'            => [static::RULE_REQUIRED, static::RULE_EMAIL, [static::RULE_UNIQUE, 'class' => static::class]],
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

	public function attributes(): array
	{
		// TODO: read the table schema and get the column names from there, then get the columns as attributes
		// This should create a model of the table - just like an ORM
		return ['first_name', 'last_name', 'email', 'password', 'status'];
	}
}