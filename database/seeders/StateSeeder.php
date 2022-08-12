<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            [
                'name' => 'Province-1',
                'country_id' => '154',
                'country_code' => 'NP',
            ],
            [
                'name' => 'Madhesh Province',
                'country_id' => '154',
                'country_code' => 'NP',
            ],
            [
                'name' => 'Bagmati Province',
                'country_id' => '154',
                'country_code' => 'NP',
            ],
            [
                'name' => 'Gandaki Province',
                'country_id' => '154',
                'country_code' => 'NP',
            ],
            [
                'name' => 'Lumbini Province',
                'country_id' => '154',
                'country_code' => 'NP',
            ],
            [
                'name' => 'Karnali Province',
                'country_id' => '154',
                'country_code' => 'NP',
            ],
            [
                'name' => 'Sudurpaschim Province',
                'country_id' => '154',
                'country_code' => 'NP',
            ],
        ];
        DB::table('states')->insert($states);
    }
}
