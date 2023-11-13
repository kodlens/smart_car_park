<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
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
                'academic_year_code' => '2021-1',
                'academic_year_desc' => '1ST SEMESTER AY 2020-2021',
                'is_active' => 0
            ],
            [
                'academic_year_code' => '2021-2',
                'academic_year_desc' => '2ND SEMESTER AY 2020-2021',
                'is_active' => 0
            ],
            [
                'academic_year_code' => '2223-1',
                'academic_year_desc' => '1ST SEMESTER AY 2022-2023',
                'is_active' => 0
            ],
            [
                'academic_year_code' => '2223-2',
                'academic_year_desc' => '2ND SEMESTER AY 2022-2023',
                'is_active' => 0
            ],
            [
                'academic_year_code' => '2324-1',
                'academic_year_desc' => '1ST SEMESTER AY 2023-2024',
                'is_active' => 1
            ],
            [
                'academic_year_code' => '2324-2',
                'academic_year_desc' => '2ND SEMESTER AY 2023-2024',
                'is_active' => 0
            ]
          

        ];

        \App\Models\AcademicYear::insertOrIgnore($data);
    }
}
