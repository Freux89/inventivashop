-- default lang & currency
INSERT INTO `permissions` (`id`, `name`, `group_name`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'default_language', 'system_settings', 'web', NULL, NULL), (NULL, 'default_currency', 'system_settings', 'web', NULL, NULL), (NULL, 'add_stock', 'manage_stock', 'web', NULL, NULL), (NULL, 'show_locations', 'manage_stock', 'web', NULL, NULL), (NULL, 'add_location', 'manage_stock', 'web', NULL, NULL), (NULL, 'edit_location', 'manage_stock', 'web', NULL, NULL), (NULL, 'publish_locations', 'manage_stock', 'web', NULL, NULL), (NULL, 'pos', 'pos', 'web', NULL, NULL);

-- product variation stocks location
UPDATE `product_variation_stocks` SET `location_id`='1' WHERE 1;

-- order group
ALTER TABLE `order_groups` CHANGE `order_code` `order_code` BIGINT(255) NOT NULL;

-- carts
ALTER TABLE `carts` CHANGE `country_id` `location_id` INT(11) NULL DEFAULT NULL;

-- order group
ALTER TABLE `order_groups` ADD `location_id` INT(11) NULL AFTER `billing_address_id`;

-- orders
ALTER TABLE `orders` ADD `location_id` INT(11) NULL AFTER `guest_user_id`;

-- order items
ALTER TABLE `order_items` ADD `location_id` INT(11) NULL AFTER `qty`;

-- product variations 
ALTER TABLE `product_variations` ADD `code` VARCHAR(255) NULL AFTER `sku`;

-- order groups
ALTER TABLE `order_groups` ADD `is_pos_order` TINYINT NOT NULL DEFAULT '0' AFTER `manual_payment_details`, ADD `pos_order_address` TEXT NULL AFTER `is_pos_order`, ADD `additional_discount_value` DOUBLE(20,2) NOT NULL DEFAULT '0.00' AFTER `pos_order_address`, ADD `additional_discount_type` VARCHAR(255) NOT NULL DEFAULT 'flat' COMMENT 'flat/percent' AFTER `additional_discount_value`, ADD `total_discount_amount` DOUBLE(20,2) NOT NULL DEFAULT '0.00' AFTER `additional_discount_type`;


-- Table structure for table `locations`
CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT 0,
  `is_published` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
-- Dumping data for table `locations` 
INSERT INTO `locations` (`id`, `name`, `banner`, `address`, `latitude`, `longitude`, `is_default`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Default Location', '', 'Default Address', NULL, NULL, 1, 1, '2023-03-27 00:54:01', '2023-03-28 02:31:29', NULL);
  
-- Indexes for table `locations` 
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);
  
-- AUTO_INCREMENT for table `locations` 
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3; 

COMMIT;
