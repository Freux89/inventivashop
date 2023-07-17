<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert(array(
            0 =>
            array('id' => '1', 'role_id' => NULL, 'user_type' => 'admin', 'name' => 'Richard Toland', 'email' => 'admin@themetags.com', 'phone' => NULL, 'email_or_otp_verified' => '0', 'verification_code' => NULL, 'new_email_verification_code' => NULL, 'password' => '$2y$10$uVEzoiGorF6ZZExpppaz0O1CDLQCtLMzrYosBBwtJxDdqTWOuBhZ6', 'remember_token' => NULL, 'provider_id' => NULL, 'avatar' => '6', 'postal_code' => NULL, 'user_balance' => '0', 'is_banned' => '0', 'shop_id' => '1', 'email_verified_at' => NULL, 'created_at' => NULL, 'updated_at' => '2023-03-12 05:32:38', 'deleted_at' => NULL)
        ));
    }
}
