<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
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
                'semester' => '1ST SEMESTER',
            ],
            [
                'semester' => '2ND SEMESTER',
            ],
        ];

        \App\Models\Semester::insertOrIgnore($data);
    }
}
