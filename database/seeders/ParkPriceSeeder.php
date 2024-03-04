<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ParkPriceSeeder extends Seeder
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
                'park_price' => 20,
          
            ],

          
        ];

        \App\Models\ParkPrice::insertOrIgnore($data);
    }
}
