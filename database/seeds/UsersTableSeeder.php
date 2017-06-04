<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// John
		User::create(array(
				'id' => '1',
				'name' => 'Dauphinais,John',
				'email' => 'john.dauphinais@orange.com',
				'password' => bcrypt('cisco123'),
				'is_manager' => 1,
				'region' => 'Europe',
				'domain' => 'Hybrid',
				'country' => 'Belgium',
				'management_code' => 'DPS22',
				'job_role' => 'DSC',
				'employee_type' => 'onshore'
			));

	}
}
