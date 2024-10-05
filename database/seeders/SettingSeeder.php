<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'setting_name' => 'notif_before_entrance',
                'setting_value' => '1',
            ],
            [
                'setting_name' => 'notif_prior_exit',
                'setting_value' => '20',
            ],
            
          
        ];

        \App\Models\Setting::insertOrIgnore($data);
    }
}
