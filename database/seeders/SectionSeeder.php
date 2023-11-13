<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
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
                'strand_id' => 4,
                'max' => 45,
                'section' => 'CHARITY'
            ],
            [
                'track_id' => 1,
                'strand_id' => 3,
                'max' => 45,
                'section' => 'COURAGE'
            ],
            [
                'track_id' => 1,
                'strand_id' => 3,
                'max' => 45,
                'section' => 'COURTESY'
            ],[
                'track_id' => 1,
                'strand_id' => 3,
                'max' => 45,
                'section' => 'FAITH'
            ],[
                'track_id' => 1,
                'strand_id' => 3,
                'max' => 45,
                'section' => 'ALS'
            ],[
                'track_id' => 1,
                'strand_id' => 3,
                'max' => 45,
                'section' => 'OHSP'
            ],[
                'track_id' => 1,
                'strand_id' => 1,
                'max' => 45,
                'section' => 'LOYALTY'
            ],[
                'track_id' => 1,
                'strand_id' => 1,
                'max' => 45,
                'section' => 'STEM 1'
            ],[
                'track_id' => 1,
                'strand_id' => 2,
                'max' => 45,
                'section' => 'HONESTY'
            ],[
                'track_id' => 1,
                'strand_id' => 2,
                'max' => 45,
                'section' => 'HUMILITY'
            ],[
                'track_id' => 1,
                'strand_id' => 2,
                'max' => 45,
                'section' => 'INTEGRITY'
            ],[
                'track_id' => 2,
                'strand_id' => 6,
                'max' => 45,
                'section' => 'PERSEVERANCE'
            ],[
                'track_id' => 2,
                'strand_id' => 7,
                'max' => 45,
                'section' => 'OBEDIENCE'
            ],[
                'track_id' => 2,
                'strand_id' => 7,
                'max' => 45,
                'section' => 'PATIENCE'
            ],[
                'track_id' => 2,
                'strand_id' => 8,
                'max' => 45,
                'section' => 'SIMPLICITY'
            ],[
                'track_id' => 2,
                'strand_id' => 9,
                'max' => 45,
                'section' => 'SINCERITY'
            ],[
                'track_id' => 1,
                'strand_id' => 3,
                'max' => 45,
                'section' => 'AMETHYST'
            ],[
                'track_id' => 1,
                'strand_id' => 3,
                'max' => 45,
                'section' => 'RHODONITE'
            ],[
                'track_id' => 1,
                'strand_id' => 3,
                'max' => 45,
                'section' => 'GARNET'
            ],[
                'track_id' => 1,
                'strand_id' => 3,
                'max' => 45,
                'section' => 'OHSP - GRADE 12'
            ],[
                'track_id' => 1,
                'strand_id' => 1,
                'max' => 45,
                'section' => 'PEARL'
            ],[
                'track_id' => 1,
                'strand_id' => 2,
                'max' => 45,
                'section' => 'JADE'
            ],[
                'track_id' => 1,
                'strand_id' => 2,
                'max' => 45,
                'section' => 'ONYX'
            ],[
                'track_id' => 1,
                'strand_id' => 2,
                'max' => 45,
                'section' => 'OPAL'
            ],[
                'track_id' => 1,
                'strand_id' => 4,
                'max' => 45,
                'section' => 'AMBER'
            ],[
                'track_id' => 2,
                'strand_id' => 9,
                'max' => 45,
                'section' => 'RUBY'
            ],[
                'track_id' => 2,
                'strand_id' => 8,
                'max' => 45,
                'section' => 'SAPPHIRE'
            ],[
                'track_id' => 2,
                'strand_id' => 6,
                'max' => 45,
                'section' => 'TOPAZ'
            ],[
                'track_id' => 2,
                'strand_id' => 7,
                'max' => 45,
                'section' => 'QUARTZ'
            ],

        ];

        \App\Models\Section::insertOrIgnore($data);
    }
}
