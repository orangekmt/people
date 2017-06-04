<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
        	[
            'id' => 1,
        		'name' => 'role-list',
        		'display_name' => 'Display Role Listing',
        		'description' => 'See only Listing Of Role'
        	],
        	[
            'id' => 2,
        		'name' => 'role-create',
        		'display_name' => 'Create Role',
        		'description' => 'Create New Role'
        	],
        	[
            'id' => 3,
        		'name' => 'role-edit',
        		'display_name' => 'Edit Role',
        		'description' => 'Edit Role'
        	],
        	[
            'id' => 4,
        		'name' => 'role-delete',
        		'display_name' => 'Delete Role',
        		'description' => 'Delete Role'
        	],
        	[
            'id' => 5,
        		'name' => 'role-assign',
        		'display_name' => 'Assign Role',
        		'description' => 'Assign Role'
        	],
        	[
            'id' => 6,
        		'name' => 'user-list',
        		'display_name' => 'Display User Listing',
        		'description' => 'See only Listing Of User'
        	],
        	[
            'id' => 7,
        		'name' => 'user-create',
        		'display_name' => 'Create User',
        		'description' => 'Create New User'
        	],
        	[
            'id' => 8,
        		'name' => 'user-edit',
        		'display_name' => 'Edit User',
        		'description' => 'Edit User'
        	],
        	[
            'id' => 9,
        		'name' => 'user-delete',
        		'display_name' => 'Delete User',
        		'description' => 'Delete User'
        	],
        	[
            'id' => 10,
        		'name' => 'activity-list',
        		'display_name' => 'Display Activity Listing',
        		'description' => 'See only Listing Of Activity'
        	],
        	[
            'id' => 11,
        		'name' => 'activity-create',
        		'display_name' => 'Create Activity',
        		'description' => 'Create New Activity'
        	],
        	[
            'id' => 12,
        		'name' => 'activity-edit',
        		'display_name' => 'Edit Activity',
        		'description' => 'Edit Activity'
        	],
        	[
            'id' => 13,
        		'name' => 'activity-delete',
        		'display_name' => 'Delete Activity',
        		'description' => 'Delete Activity'
        	],
        	[
            'id' => 14,
        		'name' => 'project-list',
        		'display_name' => 'Display Project Listing',
        		'description' => 'See only Listing Of Project'
        	],
        	[
            'id' => 15,
        		'name' => 'project-create',
        		'display_name' => 'Create Project',
        		'description' => 'Create New Project'
        	],
        	[
            'id' => 16,
        		'name' => 'project-edit',
        		'display_name' => 'Edit Project',
        		'description' => 'Edit Project'
        	],
        	[
            'id' => 17,
        		'name' => 'project-delete',
        		'display_name' => 'Delete Project',
        		'description' => 'Delete Project'
        	]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }
    }
}
