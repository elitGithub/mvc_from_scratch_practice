<?php


namespace App\Core;


use JetBrains\PhpStorm\ArrayShape;

abstract class Model
{

	public const RULE_REQUIRED = 'required';
	public const RULE_EMAIL = 'email';
	public const RULE_MIN = 'min';
	public const RULE_MAX = 'max';
	public const RULE_MATCH = 'match';
	public const RULE_UNIQUE = 'unique';

	public array $errors = [];

	public function loadData(array $data)
	{
		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}

	/**
	 * @return array
	 */
	abstract public function rules(): array;

	/**
	 * @return bool
	 */
	public function validate(): bool
	{
		foreach ($this->rules() as $attribute => $rules) {
			$value = $this->{$attribute};
			foreach ($rules as $rule) {
				$ruleName = $rule;
				if (!is_string($ruleName)) {
					$ruleName = $rule[0];
				}

				if ($ruleName === static::RULE_REQUIRED && !$value) {
					$this->addError($attribute, static::RULE_REQUIRED, $rule);
				}

				if ($ruleName === static::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
					$this->addError($attribute, static::RULE_EMAIL, $rule);
				}

				if ($ruleName === static::RULE_MIN && (strlen($value) < $rule[static::RULE_MIN])) {
					$this->addError($attribute, static::RULE_MIN, $rule);
				}

				if ($ruleName === static::RULE_MAX && (strlen($value) > $rule[static::RULE_MAX])) {
					$this->addError($attribute, static::RULE_MAX, $rule);
				}

				if ($ruleName === static::RULE_MATCH && $value !== $this->{$rule['match']}) {
					$this->addError($attribute, static::RULE_MATCH, $rule);
				}
			}
		}

		return empty($this->errors);
	}

	/**
	 * @param  string  $attribute
	 * @param  string  $rule
	 * @param  array|string  $params
	 */
	public function addError(string $attribute, string $rule, array|string $params = [])
	{
		$message = $this->errorMessages()[$rule] ?? '';
		if (is_array($params)) {
			foreach ($params as $key => $value) {
				$message = str_replace('{' . $key . '}', $value, $message);
			}
		}
		$this->errors[$attribute][] = $message;
	}

	/**
	 * @return string[]
	 */
	#[ArrayShape([
		self::RULE_REQUIRED => "string",
		self::RULE_EMAIL    => "string",
		self::RULE_MIN      => "string",
		self::RULE_MAX      => "string",
		self::RULE_MATCH    => "string",
	])] public function errorMessages(): array
	{
		return [
			static::RULE_REQUIRED => 'This field is required',
			static::RULE_EMAIL    => 'This field must be a valid email address',
			static::RULE_MIN      => 'Min length of this field must be {min}',
			static::RULE_MAX      => 'Max length of this field must be {max}',
			static::RULE_MATCH    => 'This field must be the same as {match}',
		];
	}

	public function hasError($attribute)
	{
		return $this->errors[$attribute] ?? false;
	}

	public function getFirstError($attribute)
	{
		return $this->errors[$attribute][0] ?? '';
	}
}