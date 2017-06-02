<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 100)->unique();
			$table->string('email', 255)->unique();
			$table->string('password', 255);
			$table->rememberToken('rememberToken');
			$table->timestamp('created_at')->nullable();
			$table->integer('employee_id')->unsigned()->nullable();
			$table->timestamp('updated_at')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}
