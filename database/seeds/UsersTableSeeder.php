<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Admin
		User::create(array(
				'id' => '1',
				'name' => 'admin',
				'email' => 'admin@orange.com',
				'password' => bcrypt('Cisco!23'),
				'is_manager' => 0
			));
		// John
		User::create(array(
				'id' => '2',
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
