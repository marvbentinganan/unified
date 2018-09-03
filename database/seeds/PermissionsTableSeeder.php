<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //Permissions
        $add = Permission::create([
            'name' => 'add-user',
            'display_name' => 'Add User',
            'description' => 'Allows User to Add New Users',
        ]);

        $update = Permission::create([
            'name' => 'update-user',
            'display_name' => 'Update User',
            'description' => 'Allows User to Update other Users',
        ]);

        $delete = Permission::create([
            'name' => 'delete-user',
            'display_name' => 'Delete User',
            'description' => 'Allows User to Delete another User',
        ]);

        $addpermission = Permission::create([
            'name' => 'manage-permissions',
            'display_name' => 'Manage Permissions',
            'description' => 'Allows User to Manage User Permissions',
        ]);

        $addrole = Permission::create([
            'name' => 'manage-roles',
            'display_name' => 'Manage Roles',
            'description' => 'Allows User to Manage User Roles',
        ]);

        $buildfiles = Permission::create([
            'name' => 'manage-build-files',
            'display_name' => 'Manage Build Files',
            'description' => 'Allows User to Manage Build Files',
        ]);

        $add_nav = Permission::create([
            'name' => 'add-navigation',
            'display_name' => 'Add Navigation',
            'description' => 'Allows User to add navigation menus',
        ]);

        $update_nav = Permission::create([
            'name' => 'update-navigation',
            'display_name' => 'Update Navigation',
            'description' => 'Allows User to update navigation menus',
        ]);

        $delete_nav = Permission::create([
            'name' => 'delete-navigation',
            'display_name' => 'Delete Navigation',
            'description' => 'Allows User to delete navigation menus',
        ]);
    }
}
