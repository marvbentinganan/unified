<?php

use Illuminate\Database\Seeder;
use App\Models\Build\Type;
use App\Models\Build\Group;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            'name' => "Senior High School"
        ]);

        Group::create([
            'name' => "College"
        ]);

        $admin = Type::create([
            'name' => "Administration",
            'model' => "department"
        ]);

        $admin->departments()->create([
            'name' => "Information Technology"
        ]);

        $admin->departments()->create([
            'name' => "Human Resources"
        ]);

        $academic = Type::create([
            'name' => "Academic",
            'model' => "department"
        ]);

        $academic->departments()->create([
            'name' => 'Nursing'
        ]);

        $academic->departments()->create([
            'name' => 'Physical Therapy'
        ]);

        $academic->departments()->create([
            'name' => 'Medical Technology'
        ]);

        $academic->departments()->create([
            'name' => 'Pharmacy'
        ]);

        $academic->departments()->create([
            'name' => 'Radiologic Technology'
        ]);

        $academic->departments()->create([
            'name' => 'Arts and Sciences'
        ]);

        $academic->departments()->create([
            'name' => 'Entrepreneurship'
        ]);

        $academic->departments()->create([
            'name' => 'Interdisciplinary Studies'
        ]);

        $academic->departments()->create([
            'name' => 'Psychology'
        ]);

        $academic->departments()->create([
            'name' => 'Business Administration'
        ]);

        $student = Type::create([
            'name' => "Student",
            'model' => "evaluation"
        ]);

        $student->sets()->create([
            'name' => "Student's Evaluation for Classroom Instructors"
        ]);

        $student->sets()->create([
            'name' => "Student's Evaluation for Science Laboratory Instructors"
        ]);

        $student->sets()->create([
            'name' => "Student's Evaluation for Physical Education Instructors"
        ]);

        $student->sets()->create([
            'name' => "Student's Evaluation for Computer Instructors"
        ]);

        $student->sets()->create([
            'name' => "Student's Evaluation for Skills Laboratory Instructors"
        ]);

        $supervisory = Type::create([
            'name' => "Supervisory",
            'model' => "evaluation"
        ]);

        $supervisory->sets()->create([
            'name' => "Supervisory Evaluation for Classroom Instructors"
        ]);

        $supervisory->sets()->create([
            'name' => "Supervisory Evaluation for Science Laboratory Instructors"
        ]);

        $supervisory->sets()->create([
            'name' => "Supervisory Evaluation for Physical Education Instructors"
        ]);

        $supervisory->sets()->create([
            'name' => "Supervisory Evaluation for Computer Instructors"
        ]);

        $supervisory->sets()->create([
            'name' => "Supervisory Evaluation for Skills Laboratory Instructors"
        ]);

        $revised = Type::create([
            'name' => "Revised",
            'model' => "evaluation"
        ]);

        $revised->sets()->create([
            'name' => "Revised Evaluation for 2018"
        ]);

        $gen = Type::create([
            'name' => "General Education",
            'model' => "subject"
        ]);

        $core = Type::create([
            'name' => "Core",
            'model' => "subject"
        ]);

        $staff = Type::create([
            'name' => "Staff",
            'model' => "employee"
        ]);

        $faculty = Type::create([
            'name' => "Faculty",
            'model' => "employee"
        ]);
    }
}
