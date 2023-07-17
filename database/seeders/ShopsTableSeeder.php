<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShopsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    { 
        \DB::table('shops')->delete();
        
        \DB::table('shops')->insert(array (
            0 => 
            array (
                'id' => '1','user_id' => '1','is_approved' => '1','is_verified_by_admin' => '1','is_published' => '1','shop_logo' => NULL,'shop_name' => 'Admin Shop','slug' => 'admin-shop','shop_rating' => '5','shop_address' => NULL,'min_order_amount' => '0','admin_commission_percentage' => '0','current_balance' => '0','is_cash_payout' => '0','is_bank_payout' => '0','bank_name' => NULL,'bank_acc_name' => NULL,'bank_acc_no' => NULL,'bank_routing_no' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL
            ),
        )); 
    }
}