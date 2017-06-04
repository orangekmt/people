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
			$table->string('password', 255)->nullable();
			$table->rememberToken('rememberToken');
			$table->timestamp('created_at')->nullable();
			$table->boolean('is_manager')->nullable();
			$table->timestamp('updated_at')->nullable();
			$table->boolean('from_otl')->nullable();
			$table->string('region', 100)->nullable();
			$table->string('country', 100)->nullable();
			$table->string('domain', 100)->nullable();
			$table->string('management_code', 100)->nullable();
			$table->string('job_role', 100)->nullable();
			$table->string('employee_type', 100)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}
