<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all = Permission::all();

        $super = Role::create([
          'name' => 'administrator',
          'display_name' => 'Administrator',
          'description' => 'System Administrator',
        ]);

        $super->attachPermissions($all);

        $faculty = Role::create([
          'name' => 'faculty',
          'display_name' => 'Faculty',
          'description' => 'Faculty',
        ]);

        $student = Role::create([
          'name' => 'student',
          'display_name' => 'Student',
          'description' => 'Student',
        ]);

        $dean = Role::create([
          'name' => 'management',
          'display_name' => 'Management',
          'description' => 'Deans and Managers',
        ]);

        $staff = Role::create([
          'name' => 'staff',
          'display_name' => 'Staff',
          'description' => 'Staff',
        ]);

        $guest = Role::create([
          'name' => 'guest',
          'display_name' => 'Guest',
          'description' => 'Guest',
        ]);

    }
}
