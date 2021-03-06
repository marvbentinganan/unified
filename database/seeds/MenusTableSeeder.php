<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = Role::first();

        $home = Menu::create([
            'name' => 'Home',
            'link' => 'home',
            'icon' => 'home',
            'order' => 1,
            'is_primary' => true,
            'has_children' => false,
        ]);

        $home->roles()->attach($admin->id);

        $user = Menu::create([
            'name' => 'User Management',
            'link' => null,
            'icon' => 'dropdown',
            'order' => 5,
            'is_primary' => true,
            'has_children' => true,
        ]);

        $user->roles()->attach($admin->id);

        $roles = $user->children()->create([
            'name' => 'Roles',
            'link' => 'roles',
            'icon' => 'ion-person-stalker',
            'order' => 1,
            'is_primary' => false,
            'has_children' => false,
        ]);

        $roles->roles()->attach($admin->id);

        $permissions = $user->children()->create([
            'name' => 'Permissions',
            'link' => 'permissions',
            'icon' => 'ion-key',
            'order' => 2,
            'is_primary' => false,
            'has_children' => false,
        ]);

        $permissions->roles()->attach($admin->id);

        $employees = $user->children()->create([
            'name' => 'Employees',
            'link' => 'employees',
            'icon' => 'ion-ios-people',
            'order' => 3,
            'is_primary' => false,
            'has_children' => false,
        ]);

        $employees->roles()->attach($admin->id);

        $students = $user->children()->create([
            'name' => 'Students',
            'link' => 'students',
            'icon' => 'ion-university',
            'order' => 4,
            'is_primary' => false,
            'has_children' => false,
        ]);

        $students->roles()->attach($admin->id);

        $users = $user->children()->create([
            'name' => 'Active Directory',
            'link' => 'active.directory',
            'icon' => 'ion-ios-people-outline',
            'order' => 5,
            'is_primary' => false,
            'has_children' => false,
        ]);

        $users->roles()->attach($admin->id);

        $settings = Menu::create([
            'name' => 'Settings',
            'link' => null,
            'icon' => 'dropdown',
            'order' => 6,
            'is_primary' => true,
            'has_children' => true,
        ]);

        $settings->roles()->attach($admin->id);

        $navigation = $settings->children()->create([
            'name' => 'Navigation',
            'link' => 'navigation',
            'icon' => 'ion-ios-list',
            'order' => 1,
            'is_primary' => false,
            'has_children' => false,
        ]);

        $navigation->roles()->attach($admin->id);

        $network = Menu::create([
            'name' => 'Network Services',
            'link' => null,
            'icon' => 'dropdown',
            'order' => 4,
            'is_primary' => true,
            'has_children' => true,
        ]);

        $network->roles()->attach($admin->id);

        $digihub = $network->children()->create([
            'name' => 'Digihub',
            'link' => 'digihub',
            'icon' => 'ion-monitor',
            'order' => 2,
            'is_primary' => false,
            'has_children' => false,
        ]);

        $digihub->roles()->attach($admin->id);

        $build = Menu::create([
            'name' => 'Build Files',
            'link' => null,
            'icon' => 'dropdown',
            'order' => 2,
            'is_primary' => true,
            'has_children' => true,
        ]);

        $build->roles()->attach($admin->id);
    }
}
