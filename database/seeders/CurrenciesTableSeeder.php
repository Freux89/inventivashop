<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    { 
        \DB::table('currencies')->delete();
        
        \DB::table('currencies')->insert(array (
            0 => 
            array (
                'id' => '1',
                'code' => 'usd',
                'name' => 'US Dollar',
                'symbol' => '$',
                'alignment' => '0',
                'rate' => '1',
                'is_active' => '1',
                'created_at' => '2022-11-27 12:21:37',
                'updated_at' => '2022-11-27 12:21:37',
                'deleted_at' => NULL
            ),
        )); 
    }
}