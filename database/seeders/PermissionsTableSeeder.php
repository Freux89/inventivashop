<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert(array(
            0 =>
            array('id' => '1', 'name' => 'dashboard', 'group_name' => 'dashboard', 'guard_name' => 'web'),

            array('id' => '2', 'name' => 'products', 'group_name' => 'products', 'guard_name' => 'web'),
            array('id' => '3', 'name' => 'add_products', 'group_name' => 'products', 'guard_name' => 'web'),
            array('id' => '4', 'name' => 'edit_products', 'group_name' => 'products', 'guard_name' => 'web'),
            array('id' => '5', 'name' => 'publish_products', 'group_name' => 'products', 'guard_name' => 'web'),

            array('id' => '6', 'name' => 'categories', 'group_name' => 'categories', 'guard_name' => 'web'),
            array('id' => '7', 'name' => 'add_categories', 'group_name' => 'categories', 'guard_name' => 'web'),
            array('id' => '8', 'name' => 'edit_categories', 'group_name' => 'categories', 'guard_name' => 'web'),
            array('id' => '9', 'name' => 'top_categories', 'group_name' => 'categories', 'guard_name' => 'web'),
            array('id' => '10', 'name' => 'delete_categories', 'group_name' => 'categories', 'guard_name' => 'web'),

            array('id' => '11', 'name' => 'variations', 'group_name' => 'variations', 'guard_name' => 'web'),
            array('id' => '12', 'name' => 'add_variations', 'group_name' => 'variations', 'guard_name' => 'web'),
            array('id' => '13', 'name' => 'edit_variations', 'group_name' => 'variations', 'guard_name' => 'web'),
            array('id' => '14', 'name' => 'publish_variations', 'group_name' => 'variations', 'guard_name' => 'web'),

            array('id' => '15', 'name' => 'variation_values', 'group_name' => 'variations', 'guard_name' => 'web'),
            array('id' => '16', 'name' => 'add_variation_values', 'group_name' => 'variations', 'guard_name' => 'web'),
            array('id' => '17', 'name' => 'edit_variation_values', 'group_name' => 'variations', 'guard_name' => 'web'),
            array('id' => '18', 'name' => 'publish_variation_values', 'group_name' => 'variations', 'guard_name' => 'web'),

            array('id' => '19', 'name' => 'brands', 'group_name' => 'brands', 'guard_name' => 'web'),
            array('id' => '20', 'name' => 'add_brands', 'group_name' => 'brands', 'guard_name' => 'web'),
            array('id' => '21', 'name' => 'edit_brands', 'group_name' => 'brands', 'guard_name' => 'web'),
            array('id' => '22', 'name' => 'publish_brands', 'group_name' => 'brands', 'guard_name' => 'web'),
            array('id' => '23', 'name' => 'delete_brands', 'group_name' => 'brands', 'guard_name' => 'web'),

            array('id' => '24', 'name' => 'units', 'group_name' => 'units', 'guard_name' => 'web'),
            array('id' => '25', 'name' => 'add_units', 'group_name' => 'units', 'guard_name' => 'web'),
            array('id' => '26', 'name' => 'edit_units', 'group_name' => 'units', 'guard_name' => 'web'),
            array('id' => '27', 'name' => 'publish_units', 'group_name' => 'units', 'guard_name' => 'web'),
            array('id' => '28', 'name' => 'delete_units', 'group_name' => 'units', 'guard_name' => 'web'),

            array('id' => '29', 'name' => 'taxes', 'group_name' => 'taxes', 'guard_name' => 'web'),
            array('id' => '30', 'name' => 'add_taxes', 'group_name' => 'taxes', 'guard_name' => 'web'),
            array('id' => '31', 'name' => 'edit_taxes', 'group_name' => 'taxes', 'guard_name' => 'web'),
            array('id' => '32', 'name' => 'publish_taxes', 'group_name' => 'taxes', 'guard_name' => 'web'),
            array('id' => '33', 'name' => 'delete_taxes', 'group_name' => 'taxes', 'guard_name' => 'web'),

            array('id' => '34', 'name' => 'orders', 'group_name' => 'orders', 'guard_name' => 'web'),
            array('id' => '35', 'name' => 'manage_orders', 'group_name' => 'orders', 'guard_name' => 'web'),

            array('id' => '36', 'name' => 'customers', 'group_name' => 'customers', 'guard_name' => 'web'),
            array('id' => '37', 'name' => 'ban_customers', 'group_name' => 'customers', 'guard_name' => 'web'),

            array('id' => '38', 'name' => 'staffs', 'group_name' => 'staffs', 'guard_name' => 'web'),
            array('id' => '39', 'name' => 'add_staffs', 'group_name' => 'staffs', 'guard_name' => 'web'),
            array('id' => '40', 'name' => 'edit_staffs', 'group_name' => 'staffs', 'guard_name' => 'web'),
            array('id' => '41', 'name' => 'delete_staffs', 'group_name' => 'staffs', 'guard_name' => 'web'),

            array('id' => '42', 'name' => 'tags', 'group_name' => 'tags', 'guard_name' => 'web'),
            array('id' => '43', 'name' => 'add_tags', 'group_name' => 'tags', 'guard_name' => 'web'),
            array('id' => '44', 'name' => 'edit_tags', 'group_name' => 'tags', 'guard_name' => 'web'),
            array('id' => '45', 'name' => 'delete_tags', 'group_name' => 'tags', 'guard_name' => 'web'),

            array('id' => '46', 'name' => 'pages', 'group_name' => 'pages', 'guard_name' => 'web'),
            array('id' => '47', 'name' => 'add_pages', 'group_name' => 'pages', 'guard_name' => 'web'),
            array('id' => '48', 'name' => 'edit_pages', 'group_name' => 'pages', 'guard_name' => 'web'),
            array('id' => '49', 'name' => 'delete_pages', 'group_name' => 'pages', 'guard_name' => 'web'),

            array('id' => '50', 'name' => 'blogs', 'group_name' => 'blogs', 'guard_name' => 'web'),
            array('id' => '51', 'name' => 'add_blogs', 'group_name' => 'blogs', 'guard_name' => 'web'),
            array('id' => '52', 'name' => 'edit_blogs', 'group_name' => 'blogs', 'guard_name' => 'web'),
            array('id' => '53', 'name' => 'publish_blogs', 'group_name' => 'blogs', 'guard_name' => 'web'),
            array('id' => '54', 'name' => 'delete_blogs', 'group_name' => 'blogs', 'guard_name' => 'web'),

            array('id' => '55', 'name' => 'blog_categories', 'group_name' => 'blogs', 'guard_name' => 'web'),
            array('id' => '56', 'name' => 'add_blog_categories', 'group_name' => 'blogs', 'guard_name' => 'web'),
            array('id' => '57', 'name' => 'edit_blog_categories', 'group_name' => 'blogs', 'guard_name' => 'web'),
            array('id' => '58', 'name' => 'delete_blog_categories', 'group_name' => 'blogs', 'guard_name' => 'web'),

            array('id' => '59', 'name' => 'media_manager', 'group_name' => 'media_manager', 'guard_name' => 'web'),
            array('id' => '60', 'name' => 'add_media', 'group_name' => 'media_manager', 'guard_name' => 'web'),
            array('id' => '61', 'name' => 'delete_media', 'group_name' => 'media_manager', 'guard_name' => 'web'),

            array('id' => '62', 'name' => 'newsletters', 'group_name' => 'newsletters', 'guard_name' => 'web'),
            array('id' => '63', 'name' => 'subscribers', 'group_name' => 'newsletters', 'guard_name' => 'web'),
            array('id' => '64', 'name' => 'delete_subscribers', 'group_name' => 'newsletters', 'guard_name' => 'web'),

            array('id' => '65', 'name' => 'coupons', 'group_name' => 'coupons', 'guard_name' => 'web'),
            array('id' => '66', 'name' => 'add_coupons', 'group_name' => 'coupons', 'guard_name' => 'web'),
            array('id' => '67', 'name' => 'edit_coupons', 'group_name' => 'coupons', 'guard_name' => 'web'),
            array('id' => '68', 'name' => 'delete_coupons', 'group_name' => 'coupons', 'guard_name' => 'web'),

            array('id' => '69', 'name' => 'campaigns', 'group_name' => 'campaigns', 'guard_name' => 'web'),
            array('id' => '70', 'name' => 'add_campaigns', 'group_name' => 'campaigns', 'guard_name' => 'web'),
            array('id' => '71', 'name' => 'edit_campaigns', 'group_name' => 'campaigns', 'guard_name' => 'web'),
            array('id' => '72', 'name' => 'publish_campaigns', 'group_name' => 'campaigns', 'guard_name' => 'web'),
            array('id' => '73', 'name' => 'delete_campaigns', 'group_name' => 'campaigns', 'guard_name' => 'web'),

            array('id' => '74', 'name' => 'logistics', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '75', 'name' => 'add_logistics', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '76', 'name' => 'edit_logistics', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '77', 'name' => 'publish_logistics', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '78', 'name' => 'delete_logistics', 'group_name' => 'fulfillment', 'guard_name' => 'web'),

            array('id' => '79', 'name' => 'shipping_zones', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '80', 'name' => 'add_shipping_zones', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '81', 'name' => 'edit_shipping_zones', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '82', 'name' => 'delete_shipping_zones', 'group_name' => 'fulfillment', 'guard_name' => 'web'),

            array('id' => '83', 'name' => 'shipping_cities', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '84', 'name' => 'add_shipping_cities', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '85', 'name' => 'edit_shipping_cities', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '86', 'name' => 'publish_shipping_cities', 'group_name' => 'fulfillment', 'guard_name' => 'web'),

            array('id' => '87', 'name' => 'shipping_states', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '88', 'name' => 'add_shipping_states', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '89', 'name' => 'edit_shipping_states', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '90', 'name' => 'publish_shipping_states', 'group_name' => 'fulfillment', 'guard_name' => 'web'),

            array('id' => '91', 'name' => 'shipping_countries', 'group_name' => 'fulfillment', 'guard_name' => 'web'),
            array('id' => '92', 'name' => 'publish_shipping_countries', 'group_name' => 'fulfillment', 'guard_name' => 'web'),

            array('id' => '93', 'name' => 'contact_us_messages', 'group_name' => 'contact_us_messages', 'guard_name' => 'web'),

            array('id' => '94', 'name' => 'homepage', 'group_name' => 'appearance', 'guard_name' => 'web'),
            array('id' => '95', 'name' => 'product_page', 'group_name' => 'appearance', 'guard_name' => 'web'),
            array('id' => '96', 'name' => 'product_details_page', 'group_name' => 'appearance', 'guard_name' => 'web'),
            array('id' => '97', 'name' => 'about_us_page', 'group_name' => 'appearance', 'guard_name' => 'web'),
            array('id' => '98', 'name' => 'header', 'group_name' => 'appearance', 'guard_name' => 'web'),
            array('id' => '99', 'name' => 'footer', 'group_name' => 'appearance', 'guard_name' => 'web'),

            array('id' => '100', 'name' => 'roles_and_permissions', 'group_name' => 'roles_and_permissions', 'guard_name' => 'web'),
            array('id' => '101', 'name' => 'add_roles_and_permissions', 'group_name' => 'roles_and_permissions', 'guard_name' => 'web'),
            array('id' => '102', 'name' => 'edit_roles_and_permissions', 'group_name' => 'roles_and_permissions', 'guard_name' => 'web'),
            array('id' => '103', 'name' => 'delete_roles_and_permissions', 'group_name' => 'roles_and_permissions', 'guard_name' => 'web'),

            array('id' => '104', 'name' => 'smtp_settings', 'group_name' => 'system_settings', 'guard_name' => 'web'),
            array('id' => '105', 'name' => 'general_settings', 'group_name' => 'system_settings', 'guard_name' => 'web'),

            array('id' => '106', 'name' => 'currency_settings', 'group_name' => 'system_settings', 'guard_name' => 'web'),
            array('id' => '107', 'name' => 'add_currency', 'group_name' => 'system_settings', 'guard_name' => 'web'),
            array('id' => '108', 'name' => 'edit_currency', 'group_name' => 'system_settings', 'guard_name' => 'web'),
            array('id' => '109', 'name' => 'publish_currency', 'group_name' => 'system_settings', 'guard_name' => 'web'),

            array('id' => '110', 'name' => 'language_settings', 'group_name' => 'system_settings', 'guard_name' => 'web'),
            array('id' => '111', 'name' => 'add_languages', 'group_name' => 'system_settings', 'guard_name' => 'web'),
            array('id' => '112', 'name' => 'edit_languages', 'group_name' => 'system_settings', 'guard_name' => 'web'),
            array('id' => '113', 'name' => 'publish_languages', 'group_name' => 'system_settings', 'guard_name' => 'web'),
            array('id' => '114', 'name' => 'translate_languages', 'group_name' => 'system_settings', 'guard_name' => 'web'),

            // v1.5.0
            array('id' => '115', 'name' => 'order_settings', 'group_name' => 'system_settings', 'guard_name' => 'web'),

            array('id' => '116', 'name' => 'payment_settings', 'group_name' => 'system_settings', 'guard_name' => 'web'),

            array('id' => '117', 'name' => 'order_reports', 'group_name' => 'reports', 'guard_name' => 'web'),
            array('id' => '118', 'name' => 'product_sale_reports', 'group_name' => 'reports', 'guard_name' => 'web'),
            array('id' => '119', 'name' => 'category_sale_reports', 'group_name' => 'reports', 'guard_name' => 'web'),
            array('id' => '120', 'name' => 'sales_amount_reports', 'group_name' => 'reports', 'guard_name' => 'web'),
            array('id' => '121', 'name' => 'delivery_status_reports', 'group_name' => 'reports', 'guard_name' => 'web'),

            // v2.0.0
            array('id' => '122', 'name' => 'default_language', 'group_name' => 'system_settings', 'guard_name' => 'web'),
            array('id' => '123', 'name' => 'default_currency', 'group_name' => 'system_settings', 'guard_name' => 'web'),

            array('id' => '124', 'name' => 'add_stock', 'group_name' => 'manage_stock', 'guard_name' => 'web'),
            array('id' => '125', 'name' => 'show_locations', 'group_name' => 'manage_stock', 'guard_name' => 'web'),
            array('id' => '126', 'name' => 'add_location', 'group_name' => 'manage_stock', 'guard_name' => 'web'),
            array('id' => '127', 'name' => 'edit_location', 'group_name' => 'manage_stock', 'guard_name' => 'web'),
            array('id' => '128', 'name' => 'publish_locations', 'group_name' => 'manage_stock', 'guard_name' => 'web'),

            array('id' => '129', 'name' => 'pos', 'group_name' => 'pos', 'guard_name' => 'web'),

            // 2.5.0
            array('id' => '130', 'name' => 'social_login_settings', 'group_name' => 'system_settings', 'guard_name' => 'web'),
            array('id' => '131', 'name' => 'auth_settings', 'group_name' => 'system_settings', 'guard_name' => 'web'),
            array('id' => '132', 'name' => 'otp_settings', 'group_name' => 'system_settings', 'guard_name' => 'web'),

            array('id' => '133', 'name' => 'reward_configurations', 'group_name' => 'rewards_and_wallet', 'guard_name' => 'web'),
            array('id' => '134', 'name' => 'set_reward_points', 'group_name' => 'rewards_and_wallet', 'guard_name' => 'web'),
            array('id' => '135', 'name' => 'wallet_configurations', 'group_name' => 'rewards_and_wallet', 'guard_name' => 'web'),

            array('id' => '136', 'name' => 'refund_configurations', 'group_name' => 'refunds', 'guard_name' => 'web'),
            array('id' => '137', 'name' => 'refund_requests', 'group_name' => 'refunds', 'guard_name' => 'web'),
            array('id' => '138', 'name' => 'approved_refunds', 'group_name' => 'refunds', 'guard_name' => 'web'),
            array('id' => '139', 'name' => 'rejected_refunds', 'group_name' => 'refunds', 'guard_name' => 'web'),
        ));
    }
}
