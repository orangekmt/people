<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersUsersTable extends Migration {

	public function up()
	{
		Schema::create('users_users', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('manager_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('manager_type', 100)->nullable();
			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('users_users');
	}
}
