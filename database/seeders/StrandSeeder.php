<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StrandSeeder extends Seeder
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
                'track_id' => 1,
                'strand' => 'STEM',
                'strand_desc' => 'Science Technology Engineering and Mathematics'
            ],
            [
                'track_id' => 1,
                'strand' => 'HUMSS',
                'strand_desc' => 'Humanities and Social Sciences'
            ],
            [
                'track_id' => 1,
                'strand' => 'GAS',
                'strand_desc' => 'General Academic Strand'
            ],
            [
                'track_id' => 1,
                'strand' => 'ABM',
                'strand_desc' => 'Accountancy Business and Management'
            ],
            [
                'track_id' => 2,
                'strand' => 'ICT - ANIMATION NC II',
                'strand_desc' => 'Information and Communications Technology - Animation NC II'
            ],
            [
                'track_id' => 2,
                'strand' => 'ICT - COMPUTER PROGRAMMING NC III',
                'strand_desc' => 'Information and Communications Technology - Computer Programming NC III'
            ],
            [
                'track_id' => 2,
                'strand' => 'IA - ELECTRICAL INSTALLATION AND MAINTENANCE',
                'strand_desc' => 'Industrial Arts - Electrical Installation and Maintencance'
            ],
            [
                'track_id' => 2,
                'strand' => 'HE - TOURISM',
                'strand_desc' => 'Home Economics - Tourism'
            ],
            [
                'track_id' => 2,
                'strand' => 'HE - COOKERY',
                'strand_desc' => 'Home Economics - Cookery'
            ],
           
          

        ];

        \App\Models\Strand::insertOrIgnore($data);
    }
}
