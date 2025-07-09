
DROP TABLE IF EXISTS `inspection`;
CREATE TABLE IF NOT EXISTS `inspection` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `miller_id` int(11) NOT NULL,
  `inspection_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `inspection_by` int(11) NOT NULL,
  `inspection_status` varchar(15) NOT NULL,
  `inspection_comment` varchar(150) DEFAULT NULL,
  `approval_status` varchar(15) DEFAULT NULL,
  `not_approved_comment` varchar(100) DEFAULT NULL,
  `approved_by` bigint(20) DEFAULT NULL,
  `approval_date` datetime DEFAULT NULL,
  `inspection_period_id` int(2) DEFAULT NULL,
  `cause_of_inspection` varchar(16) NOT NULL DEFAULT 'Scheduled',
  PRIMARY KEY (`id`),
  UNIQUE KEY `miller_id` (`miller_id`,`inspection_period_id`),
  UNIQUE KEY `miller_id_2` (`miller_id`,`inspection_period_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inspection_period`
--

DROP TABLE IF EXISTS `inspection_period`;
CREATE TABLE IF NOT EXISTS `inspection_period` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `period_name` varchar(100) NOT NULL,
  `period_start_time` datetime DEFAULT NULL,
  `period_end_time` datetime DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `insp_autometic_miller`
--

DROP TABLE IF EXISTS `insp_autometic_miller`;
CREATE TABLE IF NOT EXISTS `insp_autometic_miller` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `origin_status` tinyint(1) NOT NULL DEFAULT '1',
  `origin_comment` varchar(200) DEFAULT NULL,
  `pro_flowdiagram_status` tinyint(1) NOT NULL DEFAULT '1',
  `pro_flowdiagram_comment` varchar(200) DEFAULT NULL,
  `machineries_a_status` tinyint(1) NOT NULL DEFAULT '1',
  `machineries_a_comment` varchar(200) DEFAULT NULL,
  `machineries_b_status` tinyint(1) NOT NULL DEFAULT '1',
  `machineries_b_comment` varchar(200) DEFAULT NULL,
  `machineries_c_status` tinyint(1) NOT NULL DEFAULT '1',
  `machineries_c_comment` varchar(200) DEFAULT NULL,
  `machineries_d_status` tinyint(1) NOT NULL DEFAULT '1',
  `machineries_d_comment` varchar(200) DEFAULT NULL,
  `machineries_e_status` tinyint(1) NOT NULL DEFAULT '1',
  `machineries_e_comment` varchar(200) DEFAULT NULL,
  `machineries_f_status` tinyint(1) NOT NULL DEFAULT '1',
  `machineries_f_comment` varchar(200) DEFAULT NULL,
  `parameter1_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter1_name_comment` varchar(200) DEFAULT NULL,
  `parameter1_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter1_num_comment` varchar(200) DEFAULT NULL,
  `parameter1_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter1_power_comment` varchar(200) DEFAULT NULL,
  `parameter1_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter1_topower_comment` varchar(200) DEFAULT NULL,
  `parameter2_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter2_name_comment` varchar(200) DEFAULT NULL,
  `parameter2_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter2_num_comment` varchar(200) DEFAULT NULL,
  `parameter2_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter2_power_comment` varchar(200) DEFAULT NULL,
  `parameter2_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter2_topower_comment` varchar(200) DEFAULT NULL,
  `parameter3_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter3_name_comment` varchar(200) DEFAULT NULL,
  `parameter3_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter3_num_comment` varchar(200) DEFAULT NULL,
  `parameter3_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter3_power_comment` varchar(200) DEFAULT NULL,
  `parameter3_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter3_topower_comment` varchar(200) DEFAULT NULL,
  `parameter4_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter4_name_comment` varchar(200) DEFAULT NULL,
  `parameter4_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter4_num_comment` varchar(200) DEFAULT NULL,
  `parameter4_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter4_power_comment` varchar(200) DEFAULT NULL,
  `parameter4_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter4_topower_comment` varchar(200) DEFAULT NULL,
  `parameter5_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter5_name_comment` varchar(200) DEFAULT NULL,
  `parameter5_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter5_num_comment` varchar(200) DEFAULT NULL,
  `parameter5_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter5_power_comment` varchar(200) DEFAULT NULL,
  `parameter5_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter5_topower_comment` varchar(200) DEFAULT NULL,
  `parameter6_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter6_name_comment` varchar(200) DEFAULT NULL,
  `parameter6_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter6_num_comment` varchar(200) DEFAULT NULL,
  `parameter6_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter6_power_comment` varchar(200) DEFAULT NULL,
  `parameter6_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter6_topower_comment` varchar(200) DEFAULT NULL,
  `parameter7_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter7_name_comment` varchar(200) DEFAULT NULL,
  `parameter7_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter7_num_comment` varchar(200) DEFAULT NULL,
  `parameter7_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter7_power_comment` varchar(200) DEFAULT NULL,
  `parameter7_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter7_topower_comment` varchar(200) DEFAULT NULL,
  `parameter8_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter8_name_comment` varchar(200) DEFAULT NULL,
  `parameter8_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter8_num_comment` varchar(200) DEFAULT NULL,
  `parameter8_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter8_power_comment` varchar(200) DEFAULT NULL,
  `parameter8_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter8_topower_comment` varchar(200) DEFAULT NULL,
  `parameter9_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter9_name_comment` varchar(200) DEFAULT NULL,
  `parameter9_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter9_num_comment` varchar(200) DEFAULT NULL,
  `parameter9_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter9_power_comment` varchar(200) DEFAULT NULL,
  `parameter9_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter9_topower_comment` varchar(200) DEFAULT NULL,
  `parameter10_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter10_name_comment` varchar(200) DEFAULT NULL,
  `parameter10_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter10_num_comment` varchar(200) DEFAULT NULL,
  `parameter10_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter10_power_comment` varchar(200) DEFAULT NULL,
  `parameter10_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter10_topower_comment` varchar(200) DEFAULT NULL,
  `parameter11_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter11_name_comment` varchar(200) DEFAULT NULL,
  `parameter11_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter11_num_comment` varchar(200) DEFAULT NULL,
  `parameter11_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter11_power_comment` varchar(200) DEFAULT NULL,
  `parameter11_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter11_topower_comment` varchar(200) DEFAULT NULL,
  `parameter12_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter12_name_comment` varchar(200) DEFAULT NULL,
  `parameter12_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter12_num_comment` varchar(200) DEFAULT NULL,
  `parameter12_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter12_power_comment` varchar(200) DEFAULT NULL,
  `parameter12_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter12_topower_comment` varchar(200) DEFAULT NULL,
  `parameter13_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter13_name_comment` varchar(200) DEFAULT NULL,
  `parameter13_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter13_num_comment` varchar(200) DEFAULT NULL,
  `parameter13_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter13_power_comment` varchar(200) DEFAULT NULL,
  `parameter13_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter13_topower_comment` varchar(200) DEFAULT NULL,
  `parameter14_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter14_name_comment` varchar(200) DEFAULT NULL,
  `parameter14_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter14_num_comment` varchar(200) DEFAULT NULL,
  `parameter14_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter14_power_comment` varchar(200) DEFAULT NULL,
  `parameter14_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter14_topower_comment` varchar(200) DEFAULT NULL,
  `parameter15_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter15_name_comment` varchar(200) DEFAULT NULL,
  `parameter15_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter15_num_comment` varchar(200) DEFAULT NULL,
  `parameter15_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter15_power_comment` varchar(200) DEFAULT NULL,
  `parameter15_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter15_topower_comment` varchar(200) DEFAULT NULL,
  `parameter16_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter16_name_comment` varchar(200) DEFAULT NULL,
  `parameter16_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter16_num_comment` varchar(200) DEFAULT NULL,
  `parameter16_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter16_power_comment` varchar(200) DEFAULT NULL,
  `parameter16_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter16_topower_comment` varchar(200) DEFAULT NULL,
  `parameter17_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter17_name_comment` varchar(200) DEFAULT NULL,
  `parameter17_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter17_num_comment` varchar(200) DEFAULT NULL,
  `parameter17_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter17_power_comment` varchar(200) DEFAULT NULL,
  `parameter17_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter17_topower_comment` varchar(200) DEFAULT NULL,
  `parameter18_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter18_name_comment` varchar(200) DEFAULT NULL,
  `parameter18_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter18_num_comment` varchar(200) DEFAULT NULL,
  `parameter18_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter18_power_comment` varchar(200) DEFAULT NULL,
  `parameter18_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter18_topower_comment` varchar(200) DEFAULT NULL,
  `parameter19_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter19_name_comment` varchar(200) DEFAULT NULL,
  `parameter19_topower_status` tinyint(1) NOT NULL DEFAULT '1',
  `parameter19_topower_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `autometic_miller_inspection_key` (`inspection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `insp_chatal_detail`
--

DROP TABLE IF EXISTS `insp_chatal_detail`;
CREATE TABLE IF NOT EXISTS `insp_chatal_detail` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `chatal_id` int(6) NOT NULL,
  `chatal_long_status` tinyint(1) NOT NULL DEFAULT '1',
  `chatal_long_comment` varchar(200) DEFAULT NULL,
  `chatal_wide_status` tinyint(1) NOT NULL DEFAULT '1',
  `chatal_wide_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `inspection_id` (`inspection_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `insp_godown_detail`
--

DROP TABLE IF EXISTS `insp_godown_detail`;
CREATE TABLE IF NOT EXISTS `insp_godown_detail` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `godown_id` int(6) NOT NULL,
  `godown_long_status` tinyint(1) NOT NULL DEFAULT '1',
  `godown_long_comment` varchar(200) DEFAULT NULL,
  `godown_wide_status` tinyint(1) NOT NULL DEFAULT '1',
  `godown_wide_comment` varchar(200) DEFAULT NULL,
  `godown_height_status` tinyint(1) NOT NULL DEFAULT '1',
  `godown_height_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `inspection_id` (`inspection_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `insp_miller`
--

DROP TABLE IF EXISTS `insp_miller`;
CREATE TABLE IF NOT EXISTS `insp_miller` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `mill_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `mill_name_comment` varchar(200) DEFAULT NULL,
  `mill_address_status` tinyint(1) NOT NULL DEFAULT '1',
  `mill_address_comment` varchar(200) DEFAULT NULL,
  `owner_name_status` tinyint(1) NOT NULL DEFAULT '1',
  `owner_name_comment` varchar(200) DEFAULT NULL,
  `owner_address_status` tinyint(1) NOT NULL DEFAULT '1',
  `owner_address_comment` varchar(200) DEFAULT NULL,
  `chal_type_id_status` tinyint(1) NOT NULL DEFAULT '1',
  `chal_type_id_comment` varchar(200) DEFAULT NULL,
  `mill_type_id_status` tinyint(4) DEFAULT '1',
  `mill_type_id_comment` varchar(200) DEFAULT NULL,
  `license_no_status` tinyint(1) NOT NULL DEFAULT '1',
  `license_no_comment` varchar(200) DEFAULT NULL,
  `license_file_of_miller_status` tinyint(1) NOT NULL DEFAULT '1',
  `license_file_of_miller_comment` varchar(200) DEFAULT NULL,
  `date_license_status` tinyint(1) NOT NULL DEFAULT '1',
  `date_license_comment` varchar(200) DEFAULT NULL,
  `date_renewal_status` tinyint(1) NOT NULL DEFAULT '1',
  `date_renewal_comment` varchar(200) DEFAULT NULL,
  `is_electricity_status` tinyint(1) NOT NULL DEFAULT '1',
  `is_electricity_comment` varchar(200) DEFAULT NULL,
  `meter_no_status` tinyint(1) NOT NULL DEFAULT '1',
  `meter_no_comment` varchar(200) DEFAULT NULL,
  `electricity_file_of_miller_status` tinyint(1) NOT NULL DEFAULT '1',
  `electricity_file_of_miller_comment` varchar(200) DEFAULT NULL,
  `last_billing_month_status` tinyint(1) NOT NULL DEFAULT '1',
  `last_billing_month_comment` varchar(200) DEFAULT NULL,
  `min_load_capacity_status` tinyint(1) NOT NULL DEFAULT '1',
  `min_load_capacity_comment` varchar(200) DEFAULT NULL,
  `max_load_capacity_status` tinyint(1) NOT NULL DEFAULT '1',
  `max_load_capacity_comment` varchar(200) DEFAULT NULL,
  `paid_avg_bill_status` tinyint(1) NOT NULL DEFAULT '1',
  `paid_avg_bill_comment` varchar(200) DEFAULT NULL,
  `boiller_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `boiller_num_comment` varchar(200) DEFAULT NULL,
  `is_safty_vulve_status` tinyint(1) NOT NULL DEFAULT '1',
  `is_safty_vulve_comment` varchar(200) DEFAULT NULL,
  `is_presser_machine_status` tinyint(1) NOT NULL DEFAULT '1',
  `is_presser_machine_comment` varchar(200) DEFAULT NULL,
  `chimney_height_status` tinyint(1) NOT NULL DEFAULT '1',
  `chimney_height_comment` varchar(200) DEFAULT NULL,
  `chatal_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `chatal_num_comment` varchar(200) DEFAULT NULL,
  `steeping_house_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `steeping_house_num_comment` varchar(200) DEFAULT NULL,
  `godown_num_status` tinyint(4) DEFAULT '1',
  `godown_num_comment` varchar(200) DEFAULT NULL,
  `motor_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `motor_num_comment` varchar(200) DEFAULT NULL,
  `is_rubber_solar_status` tinyint(1) NOT NULL DEFAULT '1',
  `is_rubber_solar_comment` varchar(200) DEFAULT NULL,
  `millar_p_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `millar_p_power_comment` varchar(200) DEFAULT NULL,
  `mobile_no_status` tinyint(1) NOT NULL DEFAULT '1',
  `mobile_no_comment` varchar(200) DEFAULT NULL,
  `bank_account_no_status` tinyint(1) NOT NULL DEFAULT '1',
  `bank_account_no_comment` varchar(200) DEFAULT NULL,
  `nid_no_status` tinyint(1) NOT NULL DEFAULT '1',
  `nid_no_comment` varchar(200) DEFAULT NULL,
  `photo_of_miller_status` tinyint(1) NOT NULL DEFAULT '1',
  `photo_of_miller_comment` varchar(200) DEFAULT NULL,
  `tax_file_of_miller_status` tinyint(1) NOT NULL DEFAULT '1',
  `tax_file_of_miller_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `miller_inspection_key` (`inspection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `insp_motor_detail`
--

DROP TABLE IF EXISTS `insp_motor_detail`;
CREATE TABLE IF NOT EXISTS `insp_motor_detail` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `motor_id` int(6) NOT NULL,
  `motor_horse_power_status` tinyint(1) NOT NULL DEFAULT '1',
  `motor_horse_power_comment` varchar(200) DEFAULT NULL,
  `motor_holar_num_status` tinyint(1) NOT NULL DEFAULT '1',
  `motor_holar_num_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `inspection_id` (`inspection_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `insp_steeping_house_detail`
--

DROP TABLE IF EXISTS `insp_steeping_house_detail`;
CREATE TABLE IF NOT EXISTS `insp_steeping_house_detail` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `steeping_house_id` int(6) NOT NULL,
  `steeping_house_long_status` tinyint(1) NOT NULL DEFAULT '1',
  `steeping_house_long_comment` varchar(200) DEFAULT NULL,
  `steeping_house_wide_status` tinyint(1) NOT NULL DEFAULT '1',
  `steeping_house_wide_comment` varchar(200) DEFAULT NULL,
  `steeping_house_height_status` tinyint(1) NOT NULL DEFAULT '1',
  `steeping_house_height_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `inspection_id` (`inspection_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `insp_autometic_miller`
--
ALTER TABLE `insp_autometic_miller`
  ADD CONSTRAINT `autometic_miller_inspection_key` FOREIGN KEY (`inspection_id`) REFERENCES `inspection` (`id`);

--
-- Constraints for table `insp_chatal_detail`
--
ALTER TABLE `insp_chatal_detail`
  ADD CONSTRAINT `inspection_key` FOREIGN KEY (`inspection_id`) REFERENCES `inspection` (`id`);

--
-- Constraints for table `insp_godown_detail`
--
ALTER TABLE `insp_godown_detail`
  ADD CONSTRAINT `godown_inspection_key` FOREIGN KEY (`inspection_id`) REFERENCES `inspection` (`id`);

--
-- Constraints for table `insp_miller`
--
ALTER TABLE `insp_miller`
  ADD CONSTRAINT `miller_inspection_key` FOREIGN KEY (`inspection_id`) REFERENCES `inspection` (`id`);

--
-- Constraints for table `insp_motor_detail`
--
ALTER TABLE `insp_motor_detail`
  ADD CONSTRAINT `motor_inspection_key` FOREIGN KEY (`inspection_id`) REFERENCES `inspection` (`id`);

--
-- Constraints for table `insp_steeping_house_detail`
--
ALTER TABLE `insp_steeping_house_detail`
  ADD CONSTRAINT `steeping_house_inspection_key` FOREIGN KEY (`inspection_id`) REFERENCES `inspection` (`id`);


ALTER TABLE `steeping_house_detail` CHANGE `idsteeping_house_id` `steeping_house_id` INT(6) UNSIGNED NOT NULL AUTO_INCREMENT;



--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure alter for table `users`
--

ALTER TABLE `users`

CHANGE COLUMN `a_id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,

CHANGE COLUMN `username` `name` VARCHAR(100) NOT NULL ,

CHANGE COLUMN `user_email` `email` VARCHAR(100) NULL DEFAULT NULL ;


ALTER TABLE users
ADD COLUMN `email_verified_at` timestamp NULL DEFAULT NULL;
ALTER TABLE users
ADD COLUMN `remember_token` varchar(100) NULL DEFAULT NULL;
ALTER TABLE users
ADD COLUMN `created_at` timestamp NULL DEFAULT NULL;
ALTER TABLE users
ADD COLUMN `updated_at` timestamp NULL DEFAULT NULL;

ALTER TABLE users ADD COLUMN current_office_id int(4);

ALTER TABLE `users` CHANGE `user_type` `user_type` INT(4) UNSIGNED NOT NULL;


--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);


--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


--
-- Alter Table structure for table `miller`
--

ALTER TABLE miller ADD COLUMN `mobile_no` varchar(20);

ALTER TABLE miller ADD COLUMN bank_account_no varchar(20);

ALTER TABLE miller ADD COLUMN nid_no varchar(20);

ALTER TABLE miller ADD COLUMN photo_of_miller varchar(100);

ALTER TABLE miller ADD COLUMN tax_file_of_miller varchar(100);

ALTER TABLE miller ADD COLUMN license_file_of_miller varchar(100);

ALTER TABLE miller ADD COLUMN electricity_file_of_miller varchar(100);

ALTER TABLE `miller` CHANGE `streepinghouse_num` `steeping_house_num` INT(2) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `miller` ADD `miller_status` VARCHAR(15) NOT NULL DEFAULT 'new_register' AFTER `cmp_status`;

UPDATE `miller` SET `miller_status` = 'active';


--
-- Table structure for table `miller_inactive_reasons`
--

DROP TABLE IF EXISTS `miller_inactive_reasons`;
CREATE TABLE IF NOT EXISTS `miller_inactive_reasons` (
  `reason_id` int(2) UNSIGNED NOT NULL,
  `reason_name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `miller_inactive_reasons`
--

INSERT INTO `miller_inactive_reasons` (`reason_id`, `reason_name`) VALUES
(1, 'ক্লোস্ড'),
(2, 'ডিস্কোয়ালিফিকেশন'),
(3, 'ব্ল্যাকলিস্টেড');


--
-- Table structure for table `office_type`
--

DROP TABLE IF EXISTS `office_type`;
CREATE TABLE IF NOT EXISTS `office_type` (
  `office_type_id` int(2) UNSIGNED NOT NULL,
  `type_name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `office_type`
--

INSERT INTO `office_type` (`office_type_id`, `type_name`) VALUES
(1, 'HQ'),
(2, 'DCF'),
(3, 'UCF'),
(4, 'RCF'),
(5, 'LSD'),
(6, 'CSD');


--
-- Table structure for table `office`
--

DROP TABLE IF EXISTS `office`;
CREATE TABLE IF NOT EXISTS `office` (
  `office_id` int(4) UNSIGNED NOT NULL,
  `office_name` varchar(100) NOT NULL,
  `office_address` varchar(150) ,
  `division_id` int(2) ,
  `district_id` int(4) ,
  `upazilla_id` int(4) ,
  `office_type_id` int(2)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Office and Office Type change---
--

--
-- Office_type
--
ALTER TABLE `office_type` ADD PRIMARY KEY( `office_type_id`);
ALTER TABLE `office_type` CHANGE `office_type_id` `office_type_id` INT(2) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- office
--
ALTER TABLE `office` ADD PRIMARY KEY( `office_id`);
ALTER TABLE `office` CHANGE `office_id` `office_id` INT(4) UNSIGNED NOT NULL AUTO_INCREMENT;




--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(4) NOT NULL,
  `num` int(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_sub_menu` tinyint(1) DEFAULT NULL,
  `is_sub_sub_menu` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`) VALUES
(1, 1000, 'ফরম', 0, 0),
(2, 1010, 'অটোমেটিক চালকলের তথ্য ফরম', 1, 0),
(3, 1020, 'রাবার শেলার বিহীন (হাস্কিং) চালকলের তথ্য ফরম', 1, 0),
(4, 1030, 'রাবার শেলার যুক্ত (মেজর) চালকলের তথ্য ফরম', 1, 0),
(5, 2000, 'ম্যানেজ ইউজার', 0, 0),
(6, 2010, 'নতুন ইউজার তৈরি করুন', 1, 0),
(7, 2011, 'এডমিন ইউজার', 0, 1),
(8, 2012, 'DGF ইউজার', 0, 1),
(9, 2013, 'বিভাগীয় ইউজার', 0, 1),
(10, 2014, 'জেলা ইউজার', 0, 1),
(11, 2015, 'উপজেলা ইউজার', 0, 1),
(12, 2016, 'LSD ইউজার', 0, 1),
(13, 2020, 'ম্যানেজ ইউজার', 1, 0),
(14, 2021, 'ইউজার পারমিশন', 0, 1),
(15, 2022, 'ইউজার লিস্ট', 0, 1),
(16, 2023, 'ডিলিট ইউজার', 0, 1),
(17, 2024, 'এডিট DGF ইউজার', 0, 1),
(18, 2025, 'এডিট বিভাগীয় ইউজার', 0, 1),
(19, 2026, 'এডিট জেলা ও উপজেলা ইউজার', 0, 1),
(20, 3000, 'প্রতিবেদন', 0, 0),
(21, 3010, 'তথ্য অনুযায়ী', 1, 0),
(22, 3020, 'অঞ্চল অনুযায়ী', 1, 0),
(23, 3030, 'চালকলের ধরণ অনুযায়ী', 1, 0),
(24, 3040, 'সংক্ষিপ্ত প্রতিবেদন', 1, 0),
(25, 4000, 'নিয়ন্ত্রন', 0, 0),
(26, 4010, 'ডিলিট চালকল', 1, 0),
(27, 4020, 'এডিট চালকল', 1, 0),
(28, 5000, 'কনফিগারেশন', 0, 0),
(29, 5010, 'অঞ্চল', 1, 0),
(30, 5011, 'বিভাগ', 0, 1),
(31, 5012, 'জেলা', 0, 1),
(32, 5013, 'উপজেলা', 0, 1),
(33, 5020, 'সেটিং', 1, 0),
(34, 5021, 'চালের ধরন', 0, 1),
(35, 5022, 'চালকলের ধরন', 0, 1),
(36, 5023, 'মটরের ক্ষমতা', 0, 1),
(37, 5024, 'অফিসের ধরন', 0, 1),
(38, 5025, 'অফিস', 0, 1),
(39, 5030, 'পারমিশন', 1, 0),
(40, 5031, 'ইভেন্ট', 0, 1),
(41, 5032, 'ইউজারের ধরন', 0, 1),
(42, 5033, 'ইউজারের ধরন অনুযায়ী পারমিশন', 0, 1),
(43, 2027, 'এডিট LSD ইউজার', 0, 1),
(44, '1040', 'সেমি-অটোমেটিক চালকলের তথ্য ফরম', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `menu_permission`
--

DROP TABLE IF EXISTS `menu_permission`;
CREATE TABLE IF NOT EXISTS `menu_permission` (
  `menu_id` int(4) NOT NULL,
  `user_type_id` int(4) NOT NULL,
  `is_allow` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_permission`
--

INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES
(1, 99, 1, 1),
(2, 99, 1, 2),
(3, 99, 1, 3),
(4, 99, 1, 4),
(5, 99, 1, 5),
(6, 99, 1, 6),
(7, 99, 1, 7),
(8, 99, 1, 8),
(9, 99, 1, 9),
(10, 99, 1, 10),
(11, 99, 1, 11),
(12, 99, 1, 12),
(13, 99, 1, 13),
(14, 99, 1, 14),
(15, 99, 1, 15),
(16, 99, 1, 16),
(17, 99, 1, 17),
(18, 99, 1, 18),
(19, 99, 1, 19),
(20, 99, 1, 20),
(21, 99, 1, 21),
(22, 99, 1, 22),
(23, 99, 1, 23),
(24, 99, 1, 24),
(25, 99, 1, 25),
(26, 99, 1, 26),
(27, 99, 1, 27),
(28, 99, 1, 28),
(29, 99, 1, 29),
(30, 99, 1, 30),
(31, 99, 1, 31),
(32, 99, 1, 32),
(33, 99, 1, 33),
(34, 99, 1, 34),
(35, 99, 1, 35),
(36, 99, 1, 36),
(37, 99, 1, 37),
(38, 99, 1, 38),
(39, 99, 1, 39),
(40, 99, 1, 40),
(41, 99, 1, 41),
(42, 99, 1, 42),
(1, 1, 1, 43),
(2, 1, 1, 44),
(3, 1, 1, 45),
(4, 1, 1, 46),
(5, 1, 1, 47),
(6, 1, 1, 48),
(7, 1, 0, 49),
(8, 1, 0, 50),
(9, 1, 1, 51),
(10, 1, 1, 52),
(11, 1, 1, 53),
(12, 1, 1, 54),
(13, 1, 0, 55),
(14, 1, 0, 56),
(15, 1, 0, 57),
(16, 1, 0, 58),
(17, 1, 0, 59),
(18, 1, 1, 60),
(19, 1, 1, 61),
(20, 1, 1, 62),
(21, 1, 1, 63),
(22, 1, 1, 64),
(23, 1, 1, 65),
(24, 1, 1, 66),
(25, 1, 1, 67),
(26, 1, 1, 68),
(27, 1, 1, 69),
(28, 1, 0, 70),
(29, 1, 0, 71),
(30, 1, 0, 72),
(31, 1, 0, 73),
(32, 1, 0, 74),
(33, 1, 0, 75),
(34, 1, 0, 76),
(35, 1, 0, 77),
(36, 1, 0, 78),
(37, 1, 0, 79),
(38, 1, 0, 80),
(39, 1, 0, 81),
(40, 1, 0, 82),
(41, 1, 0, 83),
(42, 1, 0, 84),
(1, 108, 0, 85),
(2, 108, 0, 86),
(3, 108, 0, 87),
(4, 108, 0, 88),
(5, 108, 0, 89),
(6, 108, 0, 90),
(7, 108, 0, 91),
(8, 108, 0, 92),
(9, 108, 0, 93),
(10, 108, 0, 94),
(11, 108, 0, 95),
(12, 108, 0, 96),
(13, 108, 0, 97),
(14, 108, 0, 98),
(15, 108, 0, 99),
(16, 108, 0, 100),
(17, 108, 0, 101),
(18, 108, 0, 102),
(19, 108, 0, 103),
(20, 108, 0, 104),
(21, 108, 0, 105),
(22, 108, 0, 106),
(23, 108, 0, 107),
(24, 108, 0, 108),
(25, 108, 0, 109),
(26, 108, 0, 110),
(27, 108, 0, 111),
(28, 108, 0, 112),
(29, 108, 0, 113),
(30, 108, 0, 114),
(31, 108, 0, 115),
(32, 108, 0, 116),
(33, 108, 0, 117),
(34, 108, 0, 118),
(35, 108, 0, 119),
(36, 108, 0, 120),
(37, 108, 0, 121),
(38, 108, 0, 122),
(39, 108, 0, 123),
(40, 108, 0, 124),
(41, 108, 0, 125),
(42, 108, 0, 126),
(1, 109, 0, 127),
(2, 109, 0, 128),
(3, 109, 0, 129),
(4, 109, 0, 130),
(5, 109, 0, 131),
(6, 109, 0, 132),
(7, 109, 0, 133),
(8, 109, 0, 134),
(9, 109, 0, 135),
(10, 109, 0, 136),
(11, 109, 0, 137),
(12, 109, 0, 138),
(13, 109, 0, 139),
(14, 109, 0, 140),
(15, 109, 0, 141),
(16, 109, 0, 142),
(17, 109, 0, 143),
(18, 109, 0, 144),
(19, 109, 0, 145),
(20, 109, 0, 146),
(21, 109, 0, 147),
(22, 109, 0, 148),
(23, 109, 0, 149),
(24, 109, 0, 150),
(25, 109, 0, 151),
(26, 109, 0, 152),
(27, 109, 0, 153),
(28, 109, 0, 154),
(29, 109, 0, 155),
(30, 109, 0, 156),
(31, 109, 0, 157),
(32, 109, 0, 158),
(33, 109, 0, 159),
(34, 109, 0, 160),
(35, 109, 0, 161),
(36, 109, 0, 162),
(37, 109, 0, 163),
(38, 109, 0, 164),
(39, 109, 0, 165),
(40, 109, 0, 166),
(41, 109, 0, 167),
(42, 109, 0, 168),
(1, 100, 0, 169),
(2, 100, 0, 170),
(3, 100, 0, 171),
(4, 100, 0, 172),
(5, 100, 0, 173),
(6, 100, 0, 174),
(7, 100, 0, 175),
(8, 100, 0, 176),
(9, 100, 0, 177),
(10, 100, 0, 178),
(11, 100, 0, 179),
(12, 100, 0, 180),
(13, 100, 0, 181),
(14, 100, 0, 182),
(15, 100, 0, 183),
(16, 100, 0, 184),
(17, 100, 0, 185),
(18, 100, 0, 186),
(19, 100, 0, 187),
(20, 100, 0, 188),
(21, 100, 0, 189),
(22, 100, 0, 190),
(23, 100, 0, 191),
(24, 100, 0, 192),
(25, 100, 0, 193),
(26, 100, 0, 194),
(27, 100, 0, 195),
(28, 100, 0, 196),
(29, 100, 0, 197),
(30, 100, 0, 198),
(31, 100, 0, 199),
(32, 100, 0, 200),
(33, 100, 0, 201),
(34, 100, 0, 202),
(35, 100, 0, 203),
(36, 100, 0, 204),
(37, 100, 0, 205),
(38, 100, 0, 206),
(39, 100, 0, 207),
(40, 100, 0, 208),
(41, 100, 0, 209),
(42, 100, 0, 210),
(1, 2, 0, 211),
(2, 2, 0, 212),
(3, 2, 0, 213),
(4, 2, 0, 214),
(5, 2, 1, 215),
(6, 2, 1, 216),
(7, 2, 0, 217),
(8, 2, 0, 218),
(9, 2, 0, 219),
(10, 2, 1, 220),
(11, 2, 1, 221),
(12, 2, 1, 222),
(13, 2, 0, 223),
(14, 2, 0, 224),
(15, 2, 0, 225),
(16, 2, 0, 226),
(17, 2, 0, 227),
(18, 2, 0, 228),
(19, 2, 1, 229),
(20, 2, 1, 230),
(21, 2, 1, 231),
(22, 2, 1, 232),
(23, 2, 1, 233),
(24, 2, 1, 234),
(25, 2, 1, 235),
(26, 2, 1, 236),
(27, 2, 1, 237),
(28, 2, 0, 238),
(29, 2, 0, 239),
(30, 2, 0, 240),
(31, 2, 0, 241),
(32, 2, 0, 242),
(33, 2, 0, 243),
(34, 2, 0, 244),
(35, 2, 0, 245),
(36, 2, 0, 246),
(37, 2, 0, 247),
(38, 2, 0, 248),
(39, 2, 0, 249),
(40, 2, 0, 250),
(41, 2, 0, 251),
(42, 2, 0, 252),
(1, 3, 0, 253),
(2, 3, 0, 254),
(3, 3, 0, 255),
(4, 3, 0, 256),
(5, 3, 1, 257),
(6, 3, 1, 258),
(7, 3, 0, 259),
(8, 3, 0, 260),
(9, 3, 0, 261),
(10, 3, 0, 262),
(11, 3, 1, 263),
(12, 3, 1, 264),
(13, 3, 0, 265),
(14, 3, 0, 266),
(15, 3, 0, 267),
(16, 3, 0, 268),
(17, 3, 0, 269),
(18, 3, 0, 270),
(19, 3, 0, 271),
(20, 3, 1, 272),
(21, 3, 1, 273),
(22, 3, 1, 274),
(23, 3, 1, 275),
(24, 3, 1, 276),
(25, 3, 0, 277),
(26, 3, 0, 278),
(27, 3, 0, 279),
(28, 3, 0, 280),
(29, 3, 0, 281),
(30, 3, 0, 282),
(31, 3, 0, 283),
(32, 3, 0, 284),
(33, 3, 0, 285),
(34, 3, 0, 286),
(35, 3, 0, 287),
(36, 3, 0, 288),
(37, 3, 0, 289),
(38, 3, 0, 290),
(39, 3, 0, 291),
(40, 3, 0, 292),
(41, 3, 0, 293),
(42, 3, 0, 294),
(1, 4, 0, 295),
(2, 4, 0, 296),
(3, 4, 0, 297),
(4, 4, 0, 298),
(5, 4, 0, 299),
(6, 4, 0, 300),
(7, 4, 0, 301),
(8, 4, 0, 302),
(9, 4, 0, 303),
(10, 4, 0, 304),
(11, 4, 0, 305),
(12, 4, 0, 306),
(13, 4, 0, 307),
(14, 4, 0, 308),
(15, 4, 0, 309),
(16, 4, 0, 310),
(17, 4, 0, 311),
(18, 4, 0, 312),
(19, 4, 0, 313),
(20, 4, 1, 314),
(21, 4, 1, 315),
(22, 4, 1, 316),
(23, 4, 1, 317),
(24, 4, 1, 318),
(25, 4, 0, 319),
(26, 4, 0, 320),
(27, 4, 0, 321),
(28, 4, 0, 322),
(29, 4, 0, 323),
(30, 4, 0, 324),
(31, 4, 0, 325),
(32, 4, 0, 326),
(33, 4, 0, 327),
(34, 4, 0, 328),
(35, 4, 0, 329),
(36, 4, 0, 330),
(37, 4, 0, 331),
(38, 4, 0, 332),
(39, 4, 0, 333),
(40, 4, 0, 334),
(41, 4, 0, 335),
(42, 4, 0, 336),
(1, 5, 0, 337),
(2, 5, 0, 338),
(3, 5, 0, 339),
(4, 5, 0, 340),
(5, 5, 0, 341),
(6, 5, 0, 342),
(7, 5, 0, 343),
(8, 5, 0, 344),
(9, 5, 0, 345),
(10, 5, 0, 346),
(11, 5, 0, 347),
(12, 5, 0, 348),
(13, 5, 0, 349),
(14, 5, 0, 350),
(15, 5, 0, 351),
(16, 5, 0, 352),
(17, 5, 0, 353),
(18, 5, 0, 354),
(19, 5, 0, 355),
(20, 5, 1, 356),
(21, 5, 1, 357),
(22, 5, 1, 358),
(23, 5, 1, 359),
(24, 5, 1, 360),
(25, 5, 0, 361),
(26, 5, 0, 362),
(27, 5, 0, 363),
(28, 5, 0, 364),
(29, 5, 0, 365),
(30, 5, 0, 366),
(31, 5, 0, 367),
(32, 5, 0, 368),
(33, 5, 0, 369),
(34, 5, 0, 370),
(35, 5, 0, 371),
(36, 5, 0, 372),
(37, 5, 0, 373),
(38, 5, 0, 374),
(39, 5, 0, 375),
(40, 5, 0, 376),
(41, 5, 0, 377),
(42, 5, 0, 378),
(43, 1, 1, 379),
(43, 2, 1, 380),
(43, 3, 0, 381),
(43, 4, 0, 382),
(43, 5, 0, 383),
(43, 99, 1, 384),
(44, 1, 1, 385),
(44, 2, 0, 386),
(44, 3, 0, 387),
(44, 4, 0, 388),
(44, 5, 0, 389),
(44, 99, 1, 390);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

DROP TABLE IF EXISTS `user_type`;
CREATE TABLE IF NOT EXISTS `user_type` (
  `id` int(4) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `name`) VALUES
(1, 'DGF ইউজার'),
(2, 'বিভাগীয় ইউজার'),
(3, 'জেলা ইউজার'),
(4, 'উপজেলা ইউজার'),
(5, 'LSD ইউজার'),
(99, 'এডমিন ইউজার');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_permission`
--
ALTER TABLE `menu_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `menu_permission`
--
ALTER TABLE `menu_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


--
-- Table structure for table `activity_log`
--
DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` LONGTEXT DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_log_log_name_index` (`log_name`),
  KEY `subject` (`subject_id`,`subject_type`),
  KEY `causer` (`causer_id`,`causer_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Adding data_levelwith Menu
--
ALTER TABLE `menu` ADD `data_level` INT(2) NULL AFTER `is_sub_sub_menu`;

UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 7;
UPDATE `menu` SET `data_level` = '1' WHERE `menu`.`id` = 8;
UPDATE `menu` SET `data_level` = '2' WHERE `menu`.`id` = 9;
UPDATE `menu` SET `data_level` = '3' WHERE `menu`.`id` = 10;
UPDATE `menu` SET `data_level` = '4' WHERE `menu`.`id` = 11;
UPDATE `menu` SET `data_level` = '5' WHERE `menu`.`id` = 12;

UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 14;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 16;
UPDATE `menu` SET `data_level` = '1' WHERE `menu`.`id` = 17;
UPDATE `menu` SET `data_level` = '2' WHERE `menu`.`id` = 18;
UPDATE `menu` SET `data_level` = '3' WHERE `menu`.`id` = 19;
UPDATE `menu` SET `data_level` = '5' WHERE `menu`.`id` = 43;

UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 29;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 30;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 31;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 32;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 33;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 34;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 35;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 36;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 37;
UPDATE `menu` SET `data_level` = '1' WHERE `menu`.`id` = 38;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 39;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 40;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 41;
UPDATE `menu` SET `data_level` = '99' WHERE `menu`.`id` = 42;

UPDATE `menu` SET `data_level` = '0' WHERE `data_level` is null;


UPDATE `office_type` SET type_name = 'RCF' WHERE office_type_id=2;
UPDATE `office_type` SET type_name = 'DCF' WHERE office_type_id=3;
UPDATE `office_type` SET type_name = 'UCF' WHERE office_type_id=4;
UPDATE `office_type` SET type_name = 'CSD' WHERE office_type_id=5;
UPDATE `office_type` SET type_name = 'LCD' WHERE office_type_id=6;

-- kashem/Mam 28-jun

DROP TABLE IF EXISTS `registration_permission_time`;
CREATE TABLE IF NOT EXISTS `registration_permission_time` (
`id` INT NOT NULL AUTO_INCREMENT , 
`perm_start_time` DATETIME NOT NULL ,
`period_end_time` DATETIME NOT NULL ,
 `isActive` tinyint(2) DEFAULT NULL,
 PRIMARY KEY (`id`)) ENGINE = InnoDB;
 
-- kashem/Mam 29-jun
  
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (NULL, '5034', 'ইভেন্টস পারমিশন সময়নিরুপণ', '0', '1', '99');
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (NULL, '5035', 'রেজিস্ট্রেশন পারমিশন সময়নিরুপণ', '0', '1', '99');


INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES ('45', '99', '1', NULL);
INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES ('46', '99', '1', NULL);

 
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (NULL, '4030', 'চালকল পরিদর্শন', '1', '0', '0');
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (NULL, '5026', 'পরিদর্শন পিরিয়ড', '0', '1', '1');

INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES ('47', '99', '1', NULL);
INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES ('48', '99', '1', NULL);


--
-- For Approve Permission
--
ALTER TABLE `user_event` ADD `apr_per` TINYINT(2) NULL AFTER `edit_per`;


--
-- Table structure for table `eventpermissiontime`
--

CREATE TABLE `eventpermissiontime` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `perm_start_time` datetime NOT NULL,
  `perm_end_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `eventpermissiontime`
--
-- Indexes for table `eventpermissiontime`
--
ALTER TABLE `eventpermissiontime`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `eventpermissiontime`
--
ALTER TABLE `eventpermissiontime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

INSERT INTO `eventpermissiontime` (`id`, `event_id`, `perm_start_time`, `perm_end_time`) VALUES
(1, 1, '2020-05-30 00:00:00', '2020-07-29 00:00:00'),
(2, 2, '2020-05-30 00:00:00', '2020-06-30 00:00:00');

-- --------------------------------------------------------

--
-- Altering data for table `users`
UPDATE `users` SET `name` = 'sadmin' WHERE `users`.`id` = 1;
UPDATE `users` SET `user_type` = '99' WHERE `users`.`id` = 1;
UPDATE `users` SET `password` = 'e10adc3949ba59abbe56e057f20f883e' WHERE `users`.`id` = 1;


ALTER TABLE `miller` CHANGE `u_id` `u_id` INT(10) UNSIGNED NULL DEFAULT NULL;


CREATE UNIQUE INDEX unique_license_no ON miller(license_no);

-- kashem
ALTER TABLE miller ADD COLUMN pass_code varchar(20);

-- Zakir
ALTER TABLE `miller` ADD `miller_stage` VARCHAR(32) NOT NULL AFTER `pass_code`;
ALTER TABLE `miller` CHANGE `miller_stage` `miller_stage` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `inspection` CHANGE `approval_status` `approval_status` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- RS
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (NULL, '4040', 'পাসকোড অনুসন্ধান', '1', '0', '0');
INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES ('49', '99', '1', NULL);


-- zakir

ALTER TABLE chal_type ENGINE=InnoDB;

ALTER TABLE event ENGINE=InnoDB;
ALTER TABLE eventpermissiontime ENGINE=InnoDB;

ALTER TABLE miller_inactive_reasons ENGINE=InnoDB;
ALTER TABLE mill_type ENGINE=InnoDB;

ALTER TABLE motor_powers ENGINE=InnoDB;

ALTER TABLE office_type ENGINE=InnoDB;
ALTER TABLE office ENGINE=InnoDB;

ALTER TABLE user_type ENGINE=InnoDB;


ALTER TABLE eventpermissiontime CHANGE event_id event_id TINYINT(2) UNSIGNED NOT NULL;
ALTER TABLE eventpermissiontime ADD FOREIGN KEY (event_id) REFERENCES event(event_id);


ALTER TABLE inspection CHANGE miller_id miller_id INT(6) UNSIGNED NOT NULL;
ALTER TABLE inspection ADD FOREIGN KEY (miller_id) REFERENCES miller(miller_id);

ALTER TABLE inspection ADD FOREIGN KEY (inspection_period_id) REFERENCES inspection_period(id);


ALTER TABLE menu_permission ADD FOREIGN KEY (menu_id) REFERENCES menu(id);

ALTER TABLE miller ADD FOREIGN KEY (division_id) REFERENCES division(divid);
ALTER TABLE miller ADD FOREIGN KEY (district_id) REFERENCES district(distid);

update miller set mill_upazila_id = 2984 where mill_upazila_id = 2084;
ALTER TABLE miller ADD FOREIGN KEY (mill_upazila_id) REFERENCES upazilla(upazillaid);

ALTER TABLE miller CHANGE chal_type_id chal_type_id INT(2) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE miller ADD FOREIGN KEY (chal_type_id) REFERENCES chal_type(chal_type_id);

update miller set mill_type_id = 3 where mill_type_id = 0;
ALTER TABLE miller ADD FOREIGN KEY (mill_type_id) REFERENCES mill_type(mill_type_id);

ALTER TABLE office ADD FOREIGN KEY (division_id) REFERENCES division(divid);
ALTER TABLE office ADD FOREIGN KEY (district_id) REFERENCES district(distid);
ALTER TABLE office ADD FOREIGN KEY (upazilla_id) REFERENCES upazilla(upazillaid);

ALTER TABLE office CHANGE office_type_id office_type_id INT(2) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE office ADD FOREIGN KEY (office_type_id) REFERENCES office_type(office_type_id);

ALTER TABLE users CHANGE current_office_id current_office_id INT(4) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE users ADD FOREIGN KEY (current_office_id) REFERENCES office(office_id);

ALTER TABLE users ADD FOREIGN KEY (user_type) REFERENCES user_type(id);

ALTER TABLE user_event CHANGE event_id event_id TINYINT(2) UNSIGNED NOT NULL;
ALTER TABLE user_event ADD FOREIGN KEY (event_id) REFERENCES event(event_id);


ALTER TABLE `event` ADD `is_timebased_perm_required` INT(1) NOT NULL DEFAULT '0' AFTER `event_name`;
UPDATE `event` SET `is_timebased_perm_required` = '1' WHERE `event`.`event_id` = 1;

-- ordering in miller type, add by zakir
ALTER TABLE `mill_type` ADD `ordering` INT(2) NOT NULL DEFAULT '0' AFTER `mill_type_name`;
UPDATE `mill_type` SET `ordering` = '1' WHERE `mill_type`.`mill_type_id` = 2;
UPDATE `mill_type` SET `ordering` = '2' WHERE `mill_type`.`mill_type_id` = 1;
UPDATE `mill_type` SET `ordering` = '3' WHERE `mill_type`.`mill_type_id` = 4;
UPDATE `mill_type` SET `ordering` = '4' WHERE `mill_type`.`mill_type_id` = 3;


-- Existing date fix in miller, added by zakir
UPDATE `miller` SET `date_license` = NULL WHERE `miller`.`date_license` = '0000-00-00';
UPDATE `miller` SET `date_renewal` = NULL WHERE `miller`.`date_renewal` = '0000-00-00';
UPDATE `miller` SET `last_billing_month` = NULL WHERE `miller`.`last_billing_month` = '0000-00-00';

UPDATE `autometic_miller` SET `visited_date` = NULL WHERE `autometic_miller`.`visited_date` = '0000-00-00';

-- 20200830
UPDATE `mill_type` SET `mill_type_name` = 'রাবার শেলার ও পলিশার বিহীন হাস্কিং' WHERE (`mill_type_id` = '3');
UPDATE `mill_type` SET `mill_type_name` = 'রাবার শেলার ও পলিশার যুক্ত হাস্কিং' WHERE (`mill_type_id` = '4');

INSERT INTO `division` (`divid`, `divname`) VALUES ('45', 'ময়মনসিংহ');
UPDATE `district` SET `divid` = '45' WHERE (`distid` = '61');
UPDATE `district` SET `divid` = '45' WHERE (`distid` = '72');
UPDATE `district` SET `divid` = '45' WHERE (`distid` = '39');
UPDATE `district` SET `divid` = '45' WHERE (`distid` = '89');

UPDATE `miller` SET `division_id` = '45' WHERE `district_id` IN ( '39', '61', '72', '89');
UPDATE `office` SET `division_id` = '45' WHERE `district_id` IN ( '39', '61', '72', '89');
UPDATE `users` SET `division_id` = '45' WHERE `district_id` IN ( '39', '61', '72', '89');

-- kashem 01 september

DROP TABLE IF EXISTS `license_type`;
CREATE TABLE IF NOT EXISTS `license_type` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `license_fee`;
CREATE TABLE IF NOT EXISTS `license_fee` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `license_type_id` int(2) NOT NULL,
  `effective_todate` date NOT NULL,
  `license_fee` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `license_fee_type_key` (`license_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `license_fee`
  ADD CONSTRAINT `license_fee_type_key` FOREIGN KEY (`license_type_id`) REFERENCES `license_type` (`id`);

INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`) VALUES (NULL, 5027, 'লাইসেন্স টাইপ', 0, 1);
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`) VALUES (NULL, 5028, 'লাইসেন্স ফী', 0, 1);

INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES (50, 99, 1, NULL);
INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES (51, 99, 1, NULL);


-- 20200901 by zak
ALTER TABLE `miller` ADD `form_no` INT(8) NOT NULL AFTER `miller_id`;
ALTER TABLE `miller` ADD `father_name` VARCHAR(64) NOT NULL AFTER `owner_name`;
ALTER TABLE `miller` ADD `birth_date` DATE NULL DEFAULT NULL AFTER `father_name`;

update miller a join (
SELECT 
    @row_number:=CASE
        WHEN @customer_no = mill_upazila_id 
          THEN 
              @row_number + 1
          ELSE 
               1
        END AS num,
    @customer_no:=mill_upazila_id mill_upazila_id,
    miller_id
FROM
    miller,
    (SELECT @customer_no:=0,@row_number:=0) as t
ORDER BY 
    mill_upazila_id, miller_id
    ) b on a.miller_id = b.miller_id
    
    set a.form_no = a.mill_upazila_id * 10000 + b.num;
	
-- 20200902 by zak
ALTER TABLE `miller`  ADD `bank_name` VARCHAR(64) NULL DEFAULT NULL  AFTER `bank_account_no`;	
ALTER TABLE `miller`  ADD `bank_branch_name` VARCHAR(64) NULL DEFAULT NULL  AFTER `bank_name`;

ALTER TABLE `miller` CHANGE `pass_code` `pass_code` VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


-- 20200903 by zak

ALTER TABLE `miller` ADD `bank_account_name` VARCHAR(64) NULL DEFAULT NULL AFTER `bank_account_no`;

ALTER TABLE `miller` ADD `license_type_id` INT(2) NULL DEFAULT NULL AFTER `date_renewal`, ADD `license_deposit_amount` DOUBLE NULL DEFAULT NULL AFTER `license_type_id`, ADD `license_deposit_date` DATE NULL DEFAULT NULL AFTER `license_deposit_amount`, ADD `license_deposit_bank` VARCHAR(64) NULL DEFAULT NULL AFTER `license_deposit_date`, ADD `license_deposit_branch` VARCHAR(32) NULL DEFAULT NULL AFTER `license_deposit_bank`, ADD `license_deposit_chalan_no` VARCHAR(20) NULL DEFAULT NULL AFTER `license_deposit_branch`, ADD `license_deposit_chalan_image` VARCHAR(150) NULL DEFAULT NULL AFTER `license_deposit_chalan_no`;

DROP TABLE IF EXISTS `license_history`;
CREATE TABLE IF NOT EXISTS `license_history` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `miller_id` int(6) UNSIGNED NOT NULL,
  `license_no` varchar(100) DEFAULT NULL,
  `date_license` date DEFAULT NULL,
  `date_renewal` date DEFAULT NULL,
  `license_type_id` int(2) DEFAULT NULL,
  `license_deposit_amount` double DEFAULT NULL,
  `license_deposit_date` date DEFAULT NULL,
  `license_deposit_bank` varchar(64) DEFAULT NULL,
  `license_deposit_branch` varchar(32) DEFAULT NULL,
  `license_deposit_chalan_no` varchar(20) DEFAULT NULL,
  `license_deposit_chalan_image` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `miller_id` (`miller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `license_history`
  ADD CONSTRAINT `license_history_ibfk_1` FOREIGN KEY (`miller_id`) REFERENCES `miller` (`miller_id`);
  
ALTER TABLE `license_history` 
  ADD CONSTRAINT `license_history_type_key` FOREIGN KEY (`license_type_id`) REFERENCES `license_type` (`id`);
  
-- kashem
INSERT INTO `license_type` (`id`, `name`) VALUES (1, 'নতুন');
INSERT INTO `license_type` (`id`, `name`) VALUES (2, 'নবায়ন');
INSERT INTO `license_type` (`id`, `name`) VALUES (3, 'ডুপ্লিকেট');

-- 20200907 by zak
ALTER TABLE `license_history` ADD `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `license_deposit_chalan_image`, ADD `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;
UPDATE `miller` SET `miller_stage` = 'সচল চালকল';


-- 20200908 by zak
ALTER TABLE `miller` CHANGE `father_name` `father_name` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- 20200909 by zak
ALTER TABLE `miller` ADD `millar_p_power_chal` FLOAT(9,2) NULL DEFAULT NULL AFTER `millar_p_power`;
update `miller` set millar_p_power_chal = millar_p_power where mill_type_id = 2;
update `miller` set millar_p_power = millar_p_power_chal / 0.65 where mill_type_id = 2;
update `miller` set millar_p_power_chal = millar_p_power * 0.65 where mill_type_id != 2;


-- 2020913 by zak --
ALTER TABLE `inspection` CHANGE `inspection_status` `inspection_status` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `inspection` CHANGE `inspection_comment` `inspection_comment` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `inspection` CHANGE `not_approved_comment` `not_approved_comment` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `inspection` CHANGE `cause_of_inspection` `cause_of_inspection` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Scheduled';

ALTER TABLE `inspection` ADD `inspection_document` VARCHAR(150) NULL DEFAULT NULL AFTER `cause_of_inspection`;

ALTER TABLE `miller` CHANGE `license_deposit_branch` `license_deposit_branch` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- 2020914 by zak --
ALTER TABLE `miller` CHANGE `miller_status` `miller_status` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'new_register';
ALTER TABLE `miller` ADD `last_inspection_status` VARCHAR(32) NULL DEFAULT NULL AFTER `miller_stage`;


-- 20200915
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (NULL, '4050', 'অনবায়নকৃত লাইসেন্স', '1', '0', '99');
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (NULL, '4051', 'নবায়নকৃত লাইসেন্স', '1', '0', '99');
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (NULL, '4052', 'ডুপ্লিকেট লাইসেন্স', '1', '0', '99');
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (NULL, '4060', 'নতুন চালকল', '1', '0', '99');
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (NULL, '4070', 'একটিভিটি লগ', '1', '0', '99');

-- 20200916 by zak
UPDATE `inspection` SET `inspection_status` = 'কালো তালিকাভুক্ত (অন্যান্য)' WHERE `inspection_status` = 'কালো তালিকাভুক্ত';
UPDATE `miller` SET `last_inspection_status` = 'কালো তালিকাভুক্ত (অন্যান্য)' WHERE `last_inspection_status` = 'কালো তালিকাভুক্ত';

-- 20200917 by zak
ALTER TABLE `miller` ADD `vat_file` VARCHAR(100) NULL DEFAULT NULL AFTER `electricity_file_of_miller`, ADD `signature_file` VARCHAR(100) NULL DEFAULT NULL AFTER `vat_file`;
ALTER TABLE `license_history` ADD `vat_file` VARCHAR(100) NULL DEFAULT NULL AFTER `license_deposit_chalan_image`, ADD `signature_file` VARCHAR(100) NULL DEFAULT NULL AFTER `vat_file`;

ALTER TABLE `miller` ADD `last_inspection_date` DATETIME NULL DEFAULT NULL AFTER `last_inspection_status`;
ALTER TABLE `miller` ADD `last_inspection_period_id` INT(2) NULL DEFAULT NULL AFTER `last_inspection_date`;

-- 20200920 by zak
ALTER TABLE `miller` DROP `last_inspection_date`;
ALTER TABLE `miller` DROP `last_inspection_period_id`;

ALTER TABLE `inspection`  ADD `blacklisted_period` FLOAT(5,2) NULL DEFAULT NULL  AFTER `inspection_status`;


-- 20200922 by zak
INSERT INTO `areas_and_powers` (`miller_id`, `chatal_area_total`, `chatal_power`, `godown_area_total`, `godown_power`, `steping_area_total`, `steping_power`, `motor_area_total`, `motor_power`) SELECT a.miller_id, 0, 0, 0, 0, 0, 0, 0, 0 FROM `miller` a where a.miller_id not in (select b.miller_id from areas_and_powers b);


-- 20200923 by zak
INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES (52, 99, 1, NULL);
INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES (53, 99, 1, NULL);
INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES (54, 99, 1, NULL);
INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES (55, 99, 1, NULL);
INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES (56, 99, 1, NULL);


-- 20201011 by zak
ALTER TABLE `license_fee` ADD `name` VARCHAR(64) NOT NULL AFTER `id`;

ALTER TABLE `miller` CHANGE `license_type_id` `license_fee_id` INT(4) NULL DEFAULT NULL;

ALTER TABLE `license_history` CHANGE `license_type_id` `license_fee_id` INT(4) NULL DEFAULT NULL;

ALTER TABLE `license_history` 
  DROP FOREIGN KEY `license_history_type_key`;
  
ALTER TABLE `license_history` 
  ADD CONSTRAINT `license_history_fee_key` FOREIGN KEY (`license_fee_id`) REFERENCES `license_fee` (`id`);

ALTER TABLE `upazilla` ADD `last_miller_sl` INT(4) NOT NULL DEFAULT '0' AFTER `distid`;

	
update`upazilla` as a join 
(SELECT mill_upazila_id, max(form_no) as max_form_no, mod(max(form_no), mill_upazila_id) as max_sl, count(*) FROM `miller` group by mill_upazila_id) as b on a.upazillaid = b.mill_upazila_id
set a.last_miller_sl = b.max_sl;

-- 20201013 by ak
ALTER TABLE `miller` ADD `owner_name_english` VARCHAR(100) NULL DEFAULT NULL AFTER `owner_name`;
ALTER TABLE `miller` ADD `gender` VARCHAR(10) NULL DEFAULT 'male' AFTER `owner_name_english`;	


-- 20201013 by zak

ALTER TABLE `division` ADD `name` VARCHAR(64) NOT NULL AFTER `divid`;

ALTER TABLE `district` ADD `name` VARCHAR(64) NOT NULL AFTER `distid`;

ALTER TABLE `upazilla` ADD `name` VARCHAR(64) NOT NULL AFTER `upazillaid`;


ALTER TABLE `miller` ADD `fps_mo_status` VARCHAR(16) NULL DEFAULT NULL AFTER `last_inspection_status`;
ALTER TABLE `miller` ADD `fps_mo_last_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `fps_mo_status`;
ALTER TABLE `miller` ADD `fps_mill_status` VARCHAR(16) NULL DEFAULT NULL AFTER `fps_mo_last_date`;
ALTER TABLE `miller` ADD `fps_mill_last_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `fps_mill_status`;

-- 20201015 by ak

ALTER TABLE `miller` ADD `mother_name` VARCHAR(64) NULL DEFAULT NULL AFTER `father_name`;
INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (NULL, '4080', 'Miller status in FPS System', '1', '0', '99');
INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES (57, 99, 1, NULL);


-- 20201110 - zak
ALTER TABLE `miller_inactive_reasons` ADD PRIMARY KEY(`reason_id`);
ALTER TABLE `miller_inactive_reasons` CHANGE `reason_id` `reason_id` INT(2) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `miller` CHANGE `last_inspection_status` `last_inactive_reason` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `inspection` ADD `inactive_reason` VARCHAR(32) NULL DEFAULT NULL AFTER `inspection_status`;

UPDATE `miller_inactive_reasons` SET `reason_name` = 'বন্ধ' WHERE `miller_inactive_reasons`.`reason_id` = 1;
UPDATE `miller_inactive_reasons` SET `reason_name` = 'কালো তালিকাভুক্ত (এনআইডি)' WHERE `miller_inactive_reasons`.`reason_id` = 2;
UPDATE `miller_inactive_reasons` SET `reason_name` = 'কালো তালিকাভুক্ত (অন্যান্য)' WHERE `miller_inactive_reasons`.`reason_id` = 3;
INSERT INTO `miller_inactive_reasons` (`reason_id`, `reason_name`) VALUES (NULL, 'বারিত');

-- 20201118 - ak
ALTER TABLE `miller` modify COLUMN `owner_address` varchar(255);



