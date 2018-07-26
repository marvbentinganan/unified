<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permissions
        $add = Permission::create([
            'name' => 'add-user',
            'display_name' => 'Add User',
            'description' => 'Allows User to Add New Users'
        ]);

        $update = Permission::create([
            'name' => 'update-user',
            'display_name' => 'Update User',
            'description' => 'Allows User to Update other Users'
        ]);

        $delete = Permission::create([
            'name' => 'delete-user',
            'display_name' => 'Delete User',
            'description' => 'Allows User to Delete another User'
        ]);


        $addpermission = Permission::create([
            'name' => 'manage-permissions',
            'display_name' => 'Manage Permissions',
            'description' => 'Allows User to Manage User Permissions'
        ]);

        $addrole = Permission::create([
            'name' => 'manage-roles',
            'display_name' => 'Manage Roles',
            'description' => 'Allows User to Manage User Roles'
        ]);

        $buildfiles = Permission::create([
            'name' => 'manage-build-files',
            'display_name' => 'Manage Build Files',
            'description' => 'Allows User to Manage Build Files'
        ]);
    }
}
