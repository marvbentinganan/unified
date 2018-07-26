<?php

use Illuminate\Database\Seeder;
use App\Models\Build\Semester;
use App\Models\Build\SchoolYear;
use App\Models\Build\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SchoolYear::create([
            'name' => '2017 - 2018'
        ]);

        SchoolYear::create([
            'name' => '2018 - 2019'
        ]);

        Semester::create([
            'name' => '1st Semester'
        ]);

        Semester::create([
            'name' => '2nd Semester'
        ]);

        Semester::create([
            'name' => 'Summer'
        ]);

        Setting::create([
            'school_year_id' => 1,
            'semester_id' => 2,
        ]);
    }
}
