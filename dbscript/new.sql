
----- 23 April New Changed Start -----

DROP TABLE IF EXISTS `silo_detail`;

CREATE TABLE IF NOT EXISTS `silo_detail` (
  `silo_id` INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `miller_id` INT(6) UNSIGNED NOT NULL,
  `silo_radius` FLOAT(6,2) UNSIGNED DEFAULT NULL,
  `silo_height` FLOAT(6,2) UNSIGNED DEFAULT NULL,
  `silo_volume` FLOAT(9,2) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`silo_id`, `miller_id`),
  KEY `miller_id` (`miller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `areas_and_powers`
ADD `silo_area_total` FLOAT(9,2) UNSIGNED DEFAULT 0 AFTER `godown_power`,
ADD `silo_power` FLOAT(9,2) UNSIGNED DEFAULT 0 AFTER `silo_area_total`,
ADD `final_godown_silo_power` FLOAT(9,2) UNSIGNED DEFAULT 0 AFTER `silo_power`;

ALTER TABLE `insp_miller` ADD `miller_birth_place_status` tinyint(1) NULL DEFAULT '1' AFTER `owner_address_comment`;
ALTER TABLE `insp_miller` ADD `miller_birth_place_comment` VARCHAR(200) NULL DEFAULT NULL AFTER `miller_birth_place_status`;
ALTER TABLE `insp_miller` ADD `miller_nationality_status` tinyint(1) NULL DEFAULT '1' AFTER `miller_birth_place_comment`;
ALTER TABLE `insp_miller` ADD `miller_nationality_comment` VARCHAR(200) NULL DEFAULT NULL AFTER `miller_nationality_status`;
ALTER TABLE `insp_miller` ADD `miller_religion_status` tinyint(1) NULL DEFAULT '1' AFTER `miller_nationality_comment`;
ALTER TABLE `insp_miller` ADD `miller_religion_comment` VARCHAR(200) NULL DEFAULT NULL AFTER `miller_religion_status`;


ALTER TABLE `miller` ADD `miller_birth_place` INT(6) NULL DEFAULT NULL AFTER `owner_address`;
UPDATE miller SET miller_birth_place = district_id;
ALTER TABLE `miller` ADD `miller_nationality` VARCHAR(20) NULL DEFAULT NULL AFTER `miller_birth_place`;
UPDATE miller SET miller_nationality = 'বাংলাদেশী';
ALTER TABLE `miller` ADD `miller_religion` VARCHAR(20) NULL DEFAULT NULL AFTER `miller_nationality`;
ALTER TABLE `miller` ADD `changed_mill_type` boolean not null default 0 AFTER `mill_type_id`;
UPDATE `miller` SET `changed_mill_type` = 0;
ALTER TABLE `miller` ADD COLUMN `date_last_renewal` DATE NULL DEFAULT NULL AFTER `date_renewal`;
ALTER TABLE `license_history` ADD COLUMN `date_last_renewal` DATE NULL DEFAULT NULL AFTER `date_renewal`;
ALTER TABLE `insp_miller` ADD COLUMN `date_last_renewal_status` tinyint(1) NULL DEFAULT '1' AFTER `date_renewal_status`;
ALTER TABLE `insp_miller` ADD COLUMN `date_last_renewal_comment` VARCHAR(200) NULL DEFAULT NULL AFTER `date_last_renewal_status`;


------ 23 April New Change End ------

---- Not used-----

ALTER TABLE `insp_miller` ADD `owner_type_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `inspection_id`, ADD `owner_type_comment` VARCHAR(200) NULL DEFAULT NULL AFTER `owner_type_status`, ADD `corporate_institute_id_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `owner_type_comment`, ADD `corporate_institute_id_comment` VARCHAR(200) NULL DEFAULT NULL AFTER `corporate_institute_id_status`;





--
-- Table structure for table `corporate_institute`
--

DROP TABLE IF EXISTS `corporate_institute`;
CREATE TABLE IF NOT EXISTS `corporate_institute` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `address` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `miller` ADD `owner_type` VARCHAR(20) NULL DEFAULT 'single' AFTER `form_no`;
ALTER TABLE `miller` ADD `corporate_institute_id` INT(6) UNSIGNED NULL DEFAULT NULL AFTER `owner_type`;
ALTER TABLE `miller` ADD `silo_num` INT(2) UNSIGNED NULL DEFAULT NULL AFTER `godown_num`;

INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (62, '5036', 'কর্পোরেট প্রতিষ্ঠান', '0', '1', '99');

INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`) VALUES (62, 99, 1), (62, 1, 1), (62, 2, 0), (62, 3, 1), (62, 4, 1), (62, 6, 0)


ALTER TABLE `insp_miller` ADD `owner_type_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `inspection_id`, ADD `owner_type_comment` VARCHAR(200) NULL DEFAULT NULL AFTER `owner_type_status`, ADD `corporate_institute_id_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `owner_type_comment`, ADD `corporate_institute_id_comment` VARCHAR(200) NULL DEFAULT NULL AFTER `corporate_institute_id_status`;
