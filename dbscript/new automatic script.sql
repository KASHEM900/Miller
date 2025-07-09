
UPDATE `mill_type` SET `mill_type_name` = 'হালনাগাদকৃত অটোমেটিক' WHERE (`mill_type_id` = '5');

INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES
(58, 1050, 'হালনাগাদকৃত অটোমেটিক চালকলের তথ্য ফরম', 1, 0, 0);

INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`) VALUES
(58, 99, 1),
(58, 1, 1),
(58, 108, 0),
(58, 109, 0),
(58, 100, 0),
(58, 2, 0),
(58, 3, 1),
(58, 4, 1),
(58, 5, 0);

ALTER TABLE `miller` ADD `boiler_num` INT(2) UNSIGNED NULL AFTER `is_rubber_solar`;

ALTER TABLE `miller` ADD `dryer_num` INT(2) UNSIGNED NULL AFTER `boiler_num`;

ALTER TABLE `miller` ADD `sheller_paddy_seperator_output` FLOAT(6,2) NULL AFTER `boiler_num`, ADD `whitener_grader_output` FLOAT(6,2) NULL AFTER `sheller_paddy_seperator_output`, ADD `colour_sorter_output` FLOAT(6,2) NULL AFTER `whitener_grader_output`;


ALTER TABLE `insp_miller` ADD `boiler_num_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `is_rubber_solar_comment`, ADD `boiler_num_comment` VARCHAR(200) NULL AFTER `boiler_num_status`;

ALTER TABLE `insp_miller` ADD `dryer_num_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `boiler_num_comment`, ADD `dryer_num_comment` VARCHAR(200) NULL AFTER `dryer_num_status`;

ALTER TABLE `insp_miller` ADD `sheller_paddy_seperator_output_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `dryer_num_comment`, ADD `sheller_paddy_seperator_output_comment` VARCHAR(200) NULL AFTER `sheller_paddy_seperator_output_status`, ADD `whitener_grader_output_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `sheller_paddy_seperator_output_comment`, ADD `whitener_grader_output_comment` VARCHAR(200) NULL AFTER `whitener_grader_output_status`, ADD `colour_sorter_output_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `whitener_grader_output_comment`, ADD `colour_sorter_output_comment` VARCHAR(200) NULL AFTER `colour_sorter_output_status`;


ALTER TABLE `areas_and_powers` ADD `boiler_volume_total` FLOAT(9,2) UNSIGNED NOT NULL AFTER `miller_id`, ADD `boiler_power` FLOAT(9,2) UNSIGNED NOT NULL AFTER `boiler_volume_total`, ADD `dryer_volume_total` FLOAT(9,2) UNSIGNED NOT NULL AFTER `boiler_power`, ADD `dryer_power` FLOAT(9,2) UNSIGNED NOT NULL AFTER `dryer_volume_total`;

ALTER TABLE `areas_and_powers` ADD `milling_unit_output` FLOAT(9,2) UNSIGNED NOT NULL AFTER `motor_power`, ADD `milling_unit_power` FLOAT(9,2) UNSIGNED NOT NULL AFTER `milling_unit_output`;


--
-- Table structure for table `boiler_detail`
--

DROP TABLE IF EXISTS `boiler_detail`;
CREATE TABLE IF NOT EXISTS `boiler_detail` (
  `boiler_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `miller_id` int(6) UNSIGNED NOT NULL,
  `boiler_radius` float(6,2) UNSIGNED DEFAULT NULL,
  `cylinder_height` float(6,2) UNSIGNED DEFAULT NULL,
  `cone_height` float(6,2) UNSIGNED DEFAULT NULL,
  `boiler_volume` float(9,2) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`boiler_id`,`miller_id`),
  KEY `miller_id` (`miller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `dryer_detail`
--

DROP TABLE IF EXISTS `dryer_detail`;
CREATE TABLE IF NOT EXISTS `dryer_detail` (
  `dryer_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `miller_id` int(6) UNSIGNED NOT NULL,
  `dryer_length` float(6,2) UNSIGNED DEFAULT NULL,
  `dryer_width` float(6,2) UNSIGNED DEFAULT NULL,
  `cube_height` float(6,2) UNSIGNED DEFAULT NULL,
  `pyramid_height` float(6,2) UNSIGNED DEFAULT NULL,
  `dryer_volume` float(9,2) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`dryer_id`,`miller_id`),
  KEY `miller_id` (`miller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `insp_boiler_detail`
--

DROP TABLE IF EXISTS `insp_boiler_detail`;
CREATE TABLE IF NOT EXISTS `insp_boiler_detail` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `boiler_id` int(6) NOT NULL,
  `boiler_detail_status` tinyint(1) NOT NULL DEFAULT '1',
  `boiler_detail_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `inspection_id` (`inspection_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `insp_dryer_detail`
--

DROP TABLE IF EXISTS `insp_dryer_detail`;
CREATE TABLE IF NOT EXISTS `insp_dryer_detail` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `dryer_id` int(6) NOT NULL,
  `dryer_detail_status` tinyint(1) NOT NULL DEFAULT '1',
  `dryer_detail_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `inspection_id` (`inspection_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------- For hotfix menu -------------

INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES ('59', '5029', 'এফ পি এস হট ফিক্স', '0', '1', NULL);
INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`) VALUES
(59, 99, 1),
(59, 1, 0),
(59, 2, 0),
(59, 3, 0),
(59, 4, 0),
(59, 5, 0);


ALTER TABLE `boiler_detail` ADD `qty` INT(2) NOT NULL DEFAULT '1' AFTER `boiler_volume`;
ALTER TABLE `areas_and_powers` ADD `boiler_number_total` INT(2) UNSIGNED NOT NULL AFTER `miller_id`;
