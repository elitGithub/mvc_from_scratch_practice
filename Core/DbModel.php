<?php


namespace App\Core;


use PDOException;
use PDOStatement;

abstract class DbModel extends Model
{
	abstract public function tableName(): string;

	abstract public function attributes(): array;

	public function save(): bool
	{
		try {
			$tableName = $this->tableName();
			$attributes = $this->attributes();
			$params = array_map(fn($attr) => ":$attr", $attributes);
			$statement = static::prepare("INSERT INTO $tableName (" . implode(',',
					$attributes) . ") VALUES (" . implode(',', $params) . ");");
			foreach ($attributes as $attribute) {
				$statement->bindValue(":$attribute", $this->{$attribute});
			}
			$statement->execute();
			return true;
		} catch (PDOException $e) {
			if (method_exists($this, 'logErrors')) {
				// TODO: add log!
				$this->logErrors($e->getMessage(), $e->getTraceAsString());
			}
			return false;
		}
	}

	public static function prepare($sql): bool|PDOStatement
	{
		return Application::$app->db->pdo->prepare($sql);
	}
}