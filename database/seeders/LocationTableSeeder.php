<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('locations')->delete();

        \DB::table('locations')->insert(array(
            0 =>
            array('id' => '1', 'name' => 'Default Location', 'banner' => '', 'address' => 'Default Address', 'latitude' => NULL, 'longitude' => NULL, 'is_default' => '1', 'is_published' => '1', 'created_at' => '2023-03-27 06:54:01', 'updated_at' => '2023-03-28 08:31:29', 'deleted_at' => NULL)
        ));
    }
}
