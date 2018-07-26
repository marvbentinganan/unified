<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name', 'administrator')->first();

        $super = User::create([
            'firstname' => 'Marvin',
            'lastname' => 'Bentinganan',
            'username' => 'mebentinganan',
            'email' => 'marvbentinganan@gmail.com',
            'password' => bcrypt('0822012')
        ]);

        $super->attachRole($admin);
    }
}
