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
        		'name' => 'Guest',
        		'display_name' => 'Guest',
        		'description' => 'This role has access only to the users list'
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
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (6,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (10,2);");
        DB::statement("INSERT INTO `permission_role`(`permission_id`, `role_id`) VALUES (14,2);");
        DB::statement("INSERT INTO `role_user`(`user_id`, `role_id`) VALUES (1,1);");

      }
}
