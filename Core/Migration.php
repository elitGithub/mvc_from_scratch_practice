<?php

// @TODO: I know laravel is smarter than this. Maybe do something similar using DBAL?
namespace App\Core;


abstract class Migration
{
	public Database $db;

	public function __construct()
	{
		$this->db = Application::$app->db;
	}

	abstract public function up();

	abstract public function down();
}