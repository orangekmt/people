<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePasswordResetsTable extends Migration {

	public function up()
	{
		Schema::create('password_resets', function(Blueprint $table) {
			$table->increments('id');
			$table->string('email')->index();
			$table->timestamp('created_at');
			$table->string('token')->index();
		});
	}

	public function down()
	{
		Schema::drop('password_resets');
	}
}