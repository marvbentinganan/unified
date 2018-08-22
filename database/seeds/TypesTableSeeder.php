<?php

use Illuminate\Database\Seeder;
use App\Models\Tbi\Category;
use App\Models\Tbi\SetType;
use App\Models\Tbi\Set;
use App\Models\Build\Program;
use App\Models\Build\Designation;
use App\Models\Build\Department;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => "Senior High School"
        ]);

        $college = Department::create([
            'name' => "College"
        ]);

        $college->programs()->create([
            'name' => 'Nursing'
        ]);

        $college->programs()->create([
            'name' => 'Physical Therapy'
        ]);

        $college->programs()->create([
            'name' => 'Medical Technology'
        ]);

        $college->programs()->create([
            'name' => 'Radiologic Technology'
        ]);

        $college->programs()->create([
            'name' => 'Pharmacy'
        ]);

        $college->programs()->create([
            'name' => 'Psychology'
        ]);

        $college->programs()->create([
            'name' => 'Business Administration'
        ]);

        $college->programs()->create([
            'name' => 'Entrepreneurship'
        ]);

        $college->programs()->create([
            'name' => 'Interdisciplinary Studies'
        ]);

        $college->programs()->create([
            'name' => 'Arts and Sciences'
        ]);

        $student = SetType::create([
            'name' => "Student"
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

        $supervisory = SetType::create([
            'name' => "Supervisory"
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

        $revised = SetType::create([
            'name' => "Revised"
        ]);

        // Ratings
        $revised->ratings()->create([
            'value' => 1,
            'description' => 'Strongly Disagree'
        ]);

        $revised->ratings()->create([
            'value' => 2,
            'description' => 'Disagree'
        ]);

        $revised->ratings()->create([
            'value' => 3,
            'description' => 'Neutral'
        ]);

        $revised->ratings()->create([
            'value' => 4,
            'description' => 'Agree'
        ]);

        $revised->ratings()->create([
            'value' => 5,
            'description' => 'Strongly Agree'
        ]);

        $revised_set = $revised->sets()->create([
            'name' => "Revised Evaluation for 2018"
        ]);

        // Teaching Competence
        $teaching = Category::create([
            'name' => "Teaching Competence",
            "order" => 1
        ]);

        $a = $teaching->criterias()->create([
                'name' => "Knowledge of the Subject Matter",
                "order" => 1
            ]);

        $a1 = $a->questions()->create([
                    'ask' => "The instructor discusses the objectives, policies, guidelines, and lessons clearly."
                ]);

        $a2 = $a->questions()->create([
                    'ask' => "The instructor is able to clarify areas of confusion."
                ]);

        $a3 = $a->questions()->create([
                    'ask' => "The instructor relates the lessons within everyday life situations."
                ]);

        // $a->questions()->attach([$a1->id, $a2->id, $a3->id]);

        $b = $teaching->criterias()->create([
                'name' => "Class Management",
                "order" => 2
            ]);

        $b1 = $b->questions()->create([
                    'ask' => "The instructor begins and ends the class on time."
                ]);

        $b2 = $b->questions()->create([
                    'ask' => "The instructor maintains discipline in the classroom and is consistent and reasonable in implementing policies and guidelines."
                ]);

        $b3 = $b->questions()->create([
                    'ask' => "The instructor ensures that the learning environment is conducive."
                ]);

        // $b->questions()->attach([$b1->id, $b2->id, $b3->id]);

        $c = $teaching->criterias()->create([
                'name' => "Teaching Strategies",
                "order" => 3
            ]);

        $c1 = $c->questions()->create([
                    'ask' => "The instructors' teaching methods enhanced my learning."
                ]);

        $c2 = $c->questions()->create([
                    'ask' => "The instructor encourages me to raise questions or make comments."
                ]);

        $c3 = $c->questions()->create([
                    'ask' => "The instructor returns quizzes, test papers, and requirements promptly and gives immediate feedback."
                ]);

        $c4 = $c->questions()->create([
                    'ask' => "The instructor is fair in giving grades and evaluationg student performance."
                ]);

        // $c->questions()->attach([$c1->id, $c2->id, $c3->id, $c4->id]);

        $d = $teaching->criterias()->create([
                'name' => "Communication Skills",
                "order" => 4
            ]);

        $d1 = $d->questions()->create([
                    'ask' => "The instructor communicates effectively and shows mastery of the language used as a medium of instruction."
                ]);

        $d2 = $d->questions()->create([
                    'ask' => "The instructor has a clear and well-modulated voice."
                ]);

        $d3 = $d->questions()->create([
                    'ask' => "The instructor uses words that are understandable."
                ]);

        // $d->questions()->attach([$d1->id, $d2->id, $d3->id]);

        // $teaching->criterias()->attach([$a->id, $b->id, $c->id, $d->id]);

        // Personal Qualities

        $personal = Category::create([
            'name' => "Personal Qualities",
            "order" => 2
        ]);

        $e = $personal->criterias()->create([
                'name' => "General Appearance",
                "order" => 5
            ]);

        $e1 = $e->questions()->create([
                    'ask' => "The instructor is always well-groomed, neat and dressed properly."
                ]);

        $e2 = $e->questions()->create([
                    'ask' => "The instructor appears confident, poised, and dignified."
                ]);

        $e3 = $e->questions()->create([
                    'ask' => "The instructor has a happy disposition."
                ]);

        // $e->questions()->attach([$e1->id, $e2->id, $e3->id]);

        $f = $personal->criterias()->create([
                'name' => "Relationship",
                "order" => 6
            ]);

        $f1 = $f->questions()->create([
                    'ask' => "The instructor fosters an athmosphere of mutual respect and courtesy."
                ]);

        $f2 = $f->questions()->create([
                    'ask' => "The instructor is approachable."
                ]);

        $f3 = $f->questions()->create([
                    'ask' => "The instructor respects the opinions of the students."
                ]);

        // $f->questions()->attach([$f1->id, $f2->id, $f3->id]);

        $g = $personal->criterias()->create([
                'name' => "Attitude",
                "order" => 7
            ]);

        $g1 = $g->questions()->create([
                    'ask' => "The instructor is alert, energetic, and does not have unpleasant mannerisms."
                ]);

        $g2 = $g->questions()->create([
                    'ask' => "The instructor is friendly, symphatetic, and helpful."
                ]);

        $g3 = $g->questions()->create([
                    'ask' => "The instructor has a sense of humor."
                ]);

        // $g->questions()->attach([$g1->id, $g2->id, $g3->id]);

        // $personal->criterias()->attach([$e->id, $f->id, $g->id]);

        // $revised_set->categories()->attach([$teaching->id, $personal->id]);
    }
}
