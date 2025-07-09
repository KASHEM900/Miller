------------------------boiler machineries power--------------------------

ALTER TABLE `areas_and_powers` ADD `boiler_machineries_steampower` FLOAT(9,2) UNSIGNED NOT NULL DEFAULT '0' AFTER `boiler_number_total`, ADD `boiler_machineries_power` FLOAT(9,2) UNSIGNED NOT NULL DEFAULT '0' AFTER `boiler_machineries_steampower`;


------------------------milling unit machineries comment--------------------------
ALTER TABLE `miller` ADD `milling_unit_comment` TINYTEXT NULL DEFAULT NULL AFTER `colour_sorter_output`;


------------------------mill approve system--------------------------

ALTER TABLE `users` ADD `signature_file` VARCHAR(200) NULL DEFAULT NULL AFTER `user_type`;

ALTER TABLE `miller` ADD `approver_silo_user_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `fps_mill_last_date`, ADD `approver_rc_user_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `approver_silo_user_id`, ADD `approver_dc_user_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `approver_rc_user_id`, ADD `approver_mms_user_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `approver_dc_user_id`;

ALTER TABLE `miller` ADD `approver_silo_user_date` DATETIME NULL DEFAULT NULL AFTER `approver_mms_user_id`, ADD `approver_rc_user_date` DATETIME NULL DEFAULT NULL AFTER `approver_silo_user_date`, ADD `approver_dc_user_date` DATETIME NULL DEFAULT NULL AFTER `approver_rc_user_date`, ADD `approver_mms_user_date` DATETIME NULL DEFAULT NULL AFTER `approver_dc_user_date`;

