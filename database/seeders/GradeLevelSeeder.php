<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            [
                'grade_level' => 'GRADE 1',
            ],
            [
                'grade_level' => 'GRADE 2',
            ],
            [
                'grade_level' => 'GRADE 3',
            ],
            [
                'grade_level' => 'GRADE 4',
            ],
            [
                'grade_level' => 'GRADE 5',
            ],
            [
                'grade_level' => 'GRADE 6',
            ],
            [
                'grade_level' => 'GRADE 7',
            ],
            [
                'grade_level' => 'GRADE 8',
            ],
            [
                'grade_level' => 'GRADE 9',
            ],
            [
                'grade_level' => 'GRADE 10',
            ],
            [
                'grade_level' => 'GRADE 11',
            ],
            [
                'grade_level' => 'GRADE 12',
            ],
           
        ];

        \App\Models\GradeLevel::insertOrIgnore($data);

    }
}
