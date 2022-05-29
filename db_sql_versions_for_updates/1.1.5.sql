ALTER TABLE `purchase` CHANGE `purchaser_id` `supplier_id` BIGINT(20) UNSIGNED NOT NULL;
ALTER TABLE `purchase` ADD `purchase_status` ENUM('complete','return') NOT NULL AFTER `updated_at`;
ALTER TABLE `quotations` CHANGE `purchaser_id` `supplier_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `suppliers_country_id_foreign` (`country_id`),
  KEY `suppliers_state_id_foreign` (`state_id`),
  KEY `suppliers_created_by_foreign` (`created_by`),
  KEY `suppliers_updated_by_foreign` (`updated_by`)
);

INSERT INTO `suppliers` (`id`, `first_name`, `last_name`, `address`, `phone`, `mobile`, `country_id`, `state_id`, `city`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Default', 'Supplier', 'New York, USA', '0123456789', '0123456789', 223, 43, 'New York', NULL, NULL, NULL, '2022-01-20 08:31:53', '2022-01-20 08:31:53');

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES ('0', 'new_bage_on_product_card_visibility', '30', 'business_general', NULL, NULL, NULL, NULL);

ALTER TABLE `transaction_detail` ADD `warehouse_id` BIGINT(20) NOT NULL AFTER `type`;