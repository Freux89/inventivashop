-- permissions
INSERT INTO `permissions` (`id`, `name`, `group_name`, `guard_name`, `created_at`, `updated_at`) VALUES (NULL, 'social_login_settings', 'system_settings', 'web', NULL, NULL), (NULL, 'auth_settings', 'system_settings', 'web', NULL, NULL), (NULL, 'otp_settings', 'system_settings', 'web', NULL, NULL), (NULL, 'reward_configurations', 'rewards_and_wallet', 'web', NULL, NULL), (NULL, 'set_reward_points', 'rewards_and_wallet', 'web', NULL, NULL), (NULL, 'wallet_configurations', 'rewards_and_wallet', 'web', NULL, NULL), (NULL, 'refund_configurations', 'refunds', 'web', NULL, NULL), (NULL, 'refund_requests', 'refunds', 'web', NULL, NULL), (NULL, 'approved_refunds', 'refunds', 'web', NULL, NULL), (NULL, 'rejected_refunds', 'refunds', 'web', NULL, NULL);

-- order groups
ALTER TABLE `order_groups` ADD `total_tips_amount` DOUBLE(20,2) NOT NULL DEFAULT '0.00' AFTER `total_discount_amount`;

-- orders
ALTER TABLE `orders` ADD `tips_amount` DOUBLE(20,2) NOT NULL DEFAULT '0.00' AFTER `shipping_cost`;
ALTER TABLE `orders` ADD `reward_points` BIGINT NOT NULL DEFAULT '0.00' AFTER `tips_amount`;
 
-- products
ALTER TABLE `products` ADD `reward_points` BIGINT NOT NULL DEFAULT '0' AFTER `meta_img`;

-- order items
ALTER TABLE `order_items` ADD `reward_points` BIGINT NOT NULL DEFAULT '0' AFTER `total_price`;
ALTER TABLE `order_items` ADD `is_refunded` TINYINT NOT NULL DEFAULT '0' AFTER `reward_points`;

--
-- Table structure for table `refunds`
--

CREATE TABLE `refunds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_group_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_payment_status` varchar(255) DEFAULT NULL,
  `refund_reason` longtext DEFAULT NULL,
  `refund_reject_reason` longtext DEFAULT NULL,
  `refund_status` varchar(255) NOT NULL DEFAULT 'pending' COMMENT 'refunded/rejected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 

--
-- Table structure for table `reward_points`
--

CREATE TABLE `reward_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_group_id` bigint(20) NOT NULL,
  `total_points` bigint(20) NOT NULL DEFAULT 0,
  `is_converted` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `wallet_histories`
--

CREATE TABLE `wallet_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `payment_method` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'added' COMMENT 'added/pending/cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`); 

--
-- AUTO_INCREMENT for table `refunds`
--
ALTER TABLE `refunds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Indexes for table `reward_points`
--
ALTER TABLE `reward_points`
  ADD PRIMARY KEY (`id`);
 
--
-- AUTO_INCREMENT for table `reward_points`
--
ALTER TABLE `reward_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
  
--
-- Indexes for table `wallet_histories`
--
ALTER TABLE `wallet_histories`
  ADD PRIMARY KEY (`id`);
 
--
-- AUTO_INCREMENT for table `wallet_histories`
--
ALTER TABLE `wallet_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

COMMIT;