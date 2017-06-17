<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
        	[
            'id' => 1,
        		'name' => 'Admin',
        		'display_name' => 'Admin',
        		'description' => 'This role has access to everything'
        	],
          [
            'id' => 2,
        		'name' => 'Super Manager',
        		'display_name' => 'Super Manager',
        		'description' => 'This role is used for the managers with view for everyone'
        	],
          [
            'id' => 3,
        		'name' => 'Manager',
        		'display_name' => 'Manager',
        		'description' => 'This role is used for the managers'
        	],
          [
            'id' => 4,
        		'name' => 'User',
        		'display_name' => 'User',
        		'description' => 'This role is used for the users'
        	]
        ];

        foreach ($role as $key => $value) {
        	Role::create($value);
        }

        // Now we add the role admin to the user
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (1,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (2,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (3,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (4,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (5,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (6,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (7,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (8,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (9,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (10,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (11,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (12,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (13,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (14,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (15,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (16,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (17,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (18,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (19,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (20,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (21,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (22,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (23,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (24,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (25,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (26,1);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (5,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (6,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (7,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (8,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (10,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (20,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (21,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (22,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (23,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (24,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (25,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (26,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (6,3);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (7,3);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (8,3);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (20,3);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (21,3);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (22,3);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (24,3);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (20,4);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (22,4);");
        DB::statement("INSERT INTO `role_user`(`user_id`, `role_id`) VALUES (1,1);");
        DB::statement("INSERT INTO `role_user`(`user_id`, `role_id`) VALUES (2,2);");


      }
}
