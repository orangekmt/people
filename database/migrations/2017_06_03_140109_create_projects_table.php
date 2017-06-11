<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration {

	public function up()
	{
		Schema::create('projects', function(Blueprint $table) {
			$table->increments('id');
			$table->string('customer_name', 100);
			$table->string('project_name', 100)->unique();
			$table->string('project_type', 100)->nullable();
			$table->string('meta_activity', 100);
			$table->string('region', 100)->nullable();
			$table->string('country', 100)->nullable();
			$table->string('customer_location', 100)->nullable();
			$table->string('domain', 100)->nullable();
			$table->string('description', 255)->nullable();
			$table->date('estimated_start_date')->nullable();
			$table->date('estimated_end_date')->nullable();
			$table->string('comments', 255)->nullable();
			$table->float('LoE_onshore')->nullable();
			$table->float('LoE_nearshore')->nullable();
			$table->float('LoE_offshore')->nullable();
			$table->float('LoE_contractor')->nullable();
			$table->string('gold_order_number', 100)->nullable();
			$table->string('product_code', 100)->nullable();
			$table->float('revenue')->nullable();
			$table->string('project_status', 100)->nullable();
			$table->string('otl_project_code', 100)->nullable();
			$table->integer('win_ratio')->nullable();
			$table->integer('created_by_user_id')->unsigned()->nullable();
			$table->boolean('otl_validated')->default(0);
			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('projects');
	}
}
