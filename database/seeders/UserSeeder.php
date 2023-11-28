<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'username' => 'admin',
                'lname' => 'BERIOSO',
                'fname' => 'CJAMES',
                'mname' => 'P',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'cjames@dev.com',
                'contact_no' => '1234',
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('aa')
            ],

            [
                'username' => 'rhea',
                'lname' => 'CALUPE',
                'fname' => 'RHEA MAE',
                'mname' => 'P',
                'suffix' => '',
                'sex' => 'MALE',
                'email' => 'rhea@dev.com',
                'contact_no' => '1234',
                'role' => 'USER',
                'password' => Hash::make('aa')
            ],
        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
