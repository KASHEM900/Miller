ALTER TABLE `miller` ADD `miller_p_power_approval_file` VARCHAR(150) NULL DEFAULT NULL AFTER `millar_p_power_chal`;

-- --------------------------------------------------------

ALTER TABLE `insp_miller` ADD `miller_p_power_approval_file_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `millar_p_power_comment`, ADD `miller_p_power_approval_file_comment` VARCHAR(200) NULL DEFAULT NULL AFTER `miller_p_power_approval_file_status`;


--
-- Table structure for table `autometic_miller_new`
--

DROP TABLE IF EXISTS `autometic_miller_new`;
CREATE TABLE IF NOT EXISTS `autometic_miller_new` (
  `miller_id` int(6) UNSIGNED NOT NULL,
  `origin` varchar(120) DEFAULT NULL,
  `pro_flowdiagram` varchar(200) DEFAULT NULL,
  `milling_parts_manufacturer` varchar(120) DEFAULT NULL,
  `milling_parts_manufacturer_type` varchar(60) DEFAULT NULL,
  `boiler_certificate_file` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`miller_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `insp_autometic_miller_new`
--

DROP TABLE IF EXISTS `insp_autometic_miller_new`;
CREATE TABLE IF NOT EXISTS `insp_autometic_miller_new` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `origin_status` tinyint(1) NOT NULL DEFAULT '1',
  `origin_comment` varchar(200) DEFAULT NULL,
  `pro_flowdiagram_status` tinyint(1) NOT NULL DEFAULT '1',
  `pro_flowdiagram_comment` varchar(200) DEFAULT NULL,
  `milling_parts_manufacturer_status` tinyint(1) NOT NULL DEFAULT '1',
  `milling_parts_manufacturer_comment` varchar(200) DEFAULT NULL,
  `milling_parts_manufacturer_type_status` tinyint(1) NOT NULL DEFAULT '1',
  `milling_parts_manufacturer_type_comment` varchar(200) DEFAULT NULL,
  `boiler_certificate_file_status` tinyint(1) NOT NULL DEFAULT '1',
  `boiler_certificate_file_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `autometic_miller_new_inspection_key` (`inspection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `insp_mill_boiler_machineries`
--

DROP TABLE IF EXISTS `insp_mill_boiler_machineries`;
CREATE TABLE IF NOT EXISTS `insp_mill_boiler_machineries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `mill_boiler_machinery_id` int(9) NOT NULL,
  `mill_boiler_machinery_status` tinyint(1) NOT NULL DEFAULT '1',
  `mill_boiler_machinery_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `inspection_id` (`inspection_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `insp_mill_milling_unit_machineries`
--

DROP TABLE IF EXISTS `insp_mill_milling_unit_machineries`;
CREATE TABLE IF NOT EXISTS `insp_mill_milling_unit_machineries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `inspection_id` bigint(20) UNSIGNED NOT NULL,
  `mill_milling_unit_machinery_id` int(9) NOT NULL,
  `mill_milling_unit_machinery_status` tinyint(1) NOT NULL DEFAULT '1',
  `mill_milling_unit_machinery_comment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `inspection_id` (`inspection_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `milling_unit_machinery`
--

DROP TABLE IF EXISTS `milling_unit_machinery`;
CREATE TABLE IF NOT EXISTS `milling_unit_machinery` (
  `machinery_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT NULL,
  `ordering` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`machinery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `milling_unit_machinery`
--

INSERT INTO `milling_unit_machinery` (`machinery_id`, `name`, `ordering`) VALUES
(1, 'পেডি ক্লিনার', 1),
(2, 'ডিস্টোনার', 2),
(3, 'হাস্কার', 3),
(4, 'পেডি সেপারেটর', 4),
(5, 'হোয়াইটনার', 5),
(6, 'রোটারি শিফটার', 6),
(7, 'সিল্কি পলিশার', 7),
(8, 'আয়রন পলিশার', 8),
(9, 'লেন্থ গ্রেডার', 9),
(10, 'কালার সর্টার', 10);

-- --------------------------------------------------------

--
-- Table structure for table `mill_boiler_machineries`
--

DROP TABLE IF EXISTS `mill_boiler_machineries`;
CREATE TABLE IF NOT EXISTS `mill_boiler_machineries` (
  `mill_boiler_machinery_id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `miller_id` int(6) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `manufacturer_country` varchar(100) DEFAULT NULL,
  `import_date` date DEFAULT NULL,
  `num` int(5) DEFAULT NULL,
  `pressure` float(9,2) DEFAULT NULL,
  `power` float(9,2) DEFAULT NULL,
  `topower` float(9,2) DEFAULT NULL,
  `horse_power` float(9,2) DEFAULT NULL,
  PRIMARY KEY (`mill_boiler_machinery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mill_milling_unit_machineries`
--

DROP TABLE IF EXISTS `mill_milling_unit_machineries`;
CREATE TABLE IF NOT EXISTS `mill_milling_unit_machineries` (
  `mill_milling_unit_machinery_id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `miller_id` int(6) UNSIGNED NOT NULL,
  `machinery_id` int(3) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `manufacturer_country` varchar(100) DEFAULT NULL,
  `import_date` date DEFAULT NULL,
  `num` int(5) DEFAULT NULL,
  `join_type` varchar(25) DEFAULT NULL,
  `power` float(9,2) DEFAULT NULL,
  `topower` float(9,2) DEFAULT NULL,
  `horse_power` float(9,2) DEFAULT NULL,
  PRIMARY KEY (`mill_milling_unit_machinery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `autometic_miller_new`
--
ALTER TABLE `autometic_miller_new`
  ADD CONSTRAINT `autometic_miller_new_ibfk_1` FOREIGN KEY (`miller_id`) REFERENCES `miller` (`miller_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insp_autometic_miller_new`
--
ALTER TABLE `insp_autometic_miller_new`
  ADD CONSTRAINT `autometic_miller_new_inspection_key` FOREIGN KEY (`inspection_id`) REFERENCES `inspection` (`id`);
  

INSERT INTO `menu` (`id`, `num`, `name`, `is_sub_menu`, `is_sub_sub_menu`, `data_level`) VALUES (59, '5029', 'মিলিং ইউনিটের যন্ত্রপাতি', '0', '1', '99');

INSERT INTO `menu_permission` (`menu_id`, `user_type_id`, `is_allow`, `id`) VALUES (59, 99, 1, NULL);
  
