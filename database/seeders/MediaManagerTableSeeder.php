<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MediaManagerTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('media_managers')->delete();

        \DB::table('media_managers')->insert(array(
            0 =>
            array('id' => '1', 'user_id' => '1', 'media_file' => 'uploads/media/6AkCyw6sfJrIG2NR2MuAzGRtkA48Rmgj8ND2Hc1k.png', 'media_size' => '1916', 'media_type' => 'image', 'media_name' => 'logo.png', 'media_extension' => 'png', 'created_at' => '2023-03-12 05:04:37', 'updated_at' => '2023-03-12 05:04:37', 'deleted_at' => NULL),
            array('id' => '2', 'user_id' => '1', 'media_file' => 'uploads/media/ZithHqXrynYP6nkIfU0ei7VtWRMvuObOGd0P2tdR.png', 'media_size' => '1055', 'media_type' => 'image', 'media_name' => 'logo-white.png', 'media_extension' => 'png', 'created_at' => '2023-03-12 05:05:28', 'updated_at' => '2023-03-12 05:05:28', 'deleted_at' => NULL),
            array('id' => '3', 'user_id' => '1', 'media_file' => 'uploads/media/3WOll3QyXt5f9NNi22BRANFNCTNQRey75DYAOXd4.png', 'media_size' => '4430', 'media_type' => 'image', 'media_name' => 'payments.png', 'media_extension' => 'png', 'created_at' => '2023-03-12 05:05:48', 'updated_at' => '2023-03-12 05:05:48', 'deleted_at' => NULL),
            array('id' => '4', 'user_id' => '1', 'media_file' => 'uploads/media/LOa3BqX3ydhVC0V1fwYEyvEpM5N9NaoA0E7u3EQs.png', 'media_size' => '1742', 'media_type' => 'image', 'media_name' => 'logo.png', 'media_extension' => 'png', 'created_at' => '2023-03-12 05:07:45', 'updated_at' => '2023-03-12 05:07:45', 'deleted_at' => NULL),
            array('id' => '5', 'user_id' => '1', 'media_file' => 'uploads/media/yqqPV512Gk5DMpvCj2UllKrCl52bam3yD6QvfiPP.png', 'media_size' => '753', 'media_type' => 'image', 'media_name' => 'favicon.png', 'media_extension' => 'png', 'created_at' => '2023-03-12 05:08:14', 'updated_at' => '2023-03-12 05:08:14', 'deleted_at' => NULL),
            array('id' => '6', 'user_id' => '1', 'media_file' => 'uploads/media/dtkoInw3SD3IF3Q2I1jFtEDiE96mDD46RHB9RdxN.jpg', 'media_size' => '6502', 'media_type' => 'image', 'media_name' => '1.jpg', 'media_extension' => 'jpg', 'created_at' => '2023-03-12 05:08:43', 'updated_at' => '2023-03-12 05:08:43', 'deleted_at' => NULL)
        ));
    }
}
