ALTER TABLE `cart_items` ADD `warehouse_id` BIGINT(20) NOT NULL AFTER `product_id`;
ALTER TABLE `order_detail` ADD `warehouse_id` BIGINT(20) NOT NULL AFTER `product_id`;

CREATE TABLE IF NOT EXISTS `sale_quotations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payable` double(8,2) DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_amount` double(8,2) DEFAULT NULL,
  `amount_paid` double(8,2) DEFAULT NULL,
  `due_amount` double(8,2) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_quotations_customer_id_foreign` (`customer_id`),
  KEY `sale_quotations_warehouse_id_foreign` (`warehouse_id`),
  KEY `sale_quotations_tax_id_foreign` (`tax_id`),
  KEY `sale_quotations_created_by_foreign` (`created_by`),
  KEY `sale_quotations_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sale_quotation_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sale_quotation_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_combination_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` double(8,2) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `total` double(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_quotation_details_sale_quotation_id_foreign` (`sale_quotation_id`),
  KEY `sale_quotation_details_product_combination_id_foreign` (`product_combination_id`),
  KEY `sale_quotation_details_product_id_foreign` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `current_value`  AS  select `transaction_detail`.`reference_id` AS `reference_id`,sum(`transaction_detail`.`cr_amount`) - sum(`transaction_detail`.`dr_amount`) AS `total_amount`,`accounts`.`name` AS `name`,`accounts`.`type` AS `type` from (`accounts` left join `transaction_detail` on(`accounts`.`id` = `transaction_detail`.`account_id`)) where `accounts`.`type` in ('simple_product','variable_product') group by `accounts`.`type`,`accounts`.`reference_id` having sum(`transaction_detail`.`cr_amount`) - sum(`transaction_detail`.`dr_amount`) is not null ;

INSERT INTO `payment_method_settings` (`id`, `payment_method_id`, `key`, `value`) VALUES ('0', '9', 'razorpay_theme_color', '#DB7093');

ALTER TABLE `transaction_detail` ADD `description` TEXT NOT NULL AFTER `cr_amount`;


CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `expense_report`  AS  select `transaction_detail`.`description` AS `description`,`transaction_detail`.`dr_amount` AS `amount` from `transaction_detail` where `transaction_detail`.`account_id` in (select `accounts`.`id` from `accounts` where `accounts`.`account_type` = 'expense') ;
