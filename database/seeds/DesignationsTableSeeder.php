<?php

use Illuminate\Database\Seeder;
use App\Models\Build\Designation;

class DesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staff = Designation::create([
            'name' => "Staff"
        ]);

        $faculty = Designation::create([
            'name' => "Faculty"
        ]);

        $head = Designation::create([
            'name' => "Head"
        ]);
    }
}
