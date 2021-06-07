<?php


namespace App\Core;


abstract class DbModel extends model
{
	abstract public function tableName(): string;

	public function save() {}
}