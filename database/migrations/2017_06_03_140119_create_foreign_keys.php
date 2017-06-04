<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('activities', function(Blueprint $table) {
			$table->foreign('project_id')->references('id')->on('projects')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('activities', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('users_users', function(Blueprint $table) {
			$table->foreign('manager_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('users_users', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('activities', function(Blueprint $table) {
			$table->dropForeign('activities_project_id_foreign');
		});
		Schema::table('activities', function(Blueprint $table) {
			$table->dropForeign('activities_user_id_foreign');
		});
		Schema::table('users_users', function(Blueprint $table) {
			$table->dropForeign('users_users_manager_id_foreign');
		});
		Schema::table('users_users', function(Blueprint $table) {
			$table->dropForeign('users_users_user_id_foreign');
		});
	}
}