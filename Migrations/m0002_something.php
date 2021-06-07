<?php


namespace App\Migrations;


use App\Core\Migration;

class m0002_something extends Migration
{
	public function up()
	{
		echo 'Applying migration';
	}

	public function down()
	{
		echo 'reversing migration';
	}
}