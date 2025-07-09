ALTER TABLE `users` ADD `signature_file` VARCHAR(200) NULL DEFAULT NULL AFTER `user_type`;

ALTER TABLE `miller` ADD `approver_silo_user_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `fps_mill_last_date`, ADD `approver_rc_user_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `approver_silo_user_id`, ADD `approver_dc_user_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `approver_rc_user_id`, ADD `approver_mms_user_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `approver_dc_user_id`;

ALTER TABLE `miller` ADD `approver_silo_user_date` DATETIME NULL DEFAULT NULL AFTER `approver_mms_user_id`, ADD `approver_rc_user_date` DATETIME NULL DEFAULT NULL AFTER `approver_silo_user_date`, ADD `approver_dc_user_date` DATETIME NULL DEFAULT NULL AFTER `approver_rc_user_date`, ADD `approver_mms_user_date` DATETIME NULL DEFAULT NULL AFTER `approver_dc_user_date`;
