<?php

use Illuminate\Database\Seeder;
use App\Models\Tbi\Category;
use App\Models\Tbi\Criteria;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teaching = Category::create([
            'name' => "Teaching Competencies",
            'value' => null,
            'order' => 1
        ]);

        $teaching->criterias()->create([
            'name' => "Knowledge of the Subject Matter",
            'value' => null,
            'order' => 1
        ]);

        $teaching->criterias()->create([
            'name' => "Class Management",
            'value' => null,
            'order' => 2
        ]);

        $teaching->criterias()->create([
            'name' => "Teaching Strategies",
            'value' => null,
            'order' => 3
        ]);

        $teaching->criterias()->create([
            'name' => "Communication Skills",
            'value' => null,
            'order' => 4
        ]);

        $personal = Category::create([
            'name' => "Personal Qualities",
            'value' => null,
            'order' => 2
        ]);

        $personal->criterias()->create([
            'name' => "General Appearance",
            'value' => null,
            'order' => 5
        ]);

        $personal->criterias()->create([
            'name' => "Relationship",
            'value' => null,
            'order' => 6
        ]);

        $personal->criterias()->create([
            'name' => "Attitude",
            'value' => null,
            'order' => 7
        ]);
    }
}
