<?php


namespace App\Core\Forms;


use App\Core\Model;

class Field
{
	public const TYPE_TEXT = 'text';
	public const TYPE_PASSWORD = 'password';
	public const TYPE_NUMBER = 'number';
	protected string $type;

	public function __construct(public Model $model, public string $attribute)
	{
		$this->setType(static::TYPE_TEXT);
	}

	public function __toString(): string
	{
		return sprintf('
			<div class="form-group">
				<label for="%s"> %s </label>
				<input id="%s" type="%s" name="%s" value="%s" class="form-control %s">
				<div class="invalid-feedback">%s</div>
			</div>',
			$this->attribute,
			$this->prettyLabels($this->attribute),
			$this->attribute,
			$this->type,
			$this->attribute,
			$this->model->{$this->attribute},
			$this->model->hasError($this->attribute) ? ' is-invalid' : '',
			$this->model->getFirstError($this->attribute));
	}

	/**
	 * @param  string  $type
	 */
	public function setType(string $type): void
	{
		$this->type = $type;
	}

	/**
	 * @param $string
	 *
	 * @return string
	 */
	private function prettyLabels($string): string
	{
		$string = str_replace('_', ' ', $string);
		return ucfirst($string);
	}

	/**
	 * @return $this
	 */
	public function passwordField(): static
	{
		$this->setType(static::TYPE_PASSWORD);
		return $this;
	}



}