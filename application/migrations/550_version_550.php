<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_550 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
    	$this->db->query("CREATE TABLE IF NOT EXISTS `offline_fees_payments` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `payment_method` int NOT NULL,
						  `invoice_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
						  `student_enroll_id` int DEFAULT NULL,
						  `fees_allocation_id` int DEFAULT NULL,
						  `fees_type_id` int DEFAULT NULL,
						  `payment_date` date DEFAULT NULL,
						  `reference` varchar(200) DEFAULT NULL,
						  `amount` float(10,2) DEFAULT NULL,
						  `submit_date` datetime DEFAULT NULL,
						  `approve_date` datetime DEFAULT NULL,
						  `orig_file_name` varchar(255) DEFAULT NULL,
						  `enc_file_name` text CHARACTER SET utf8 COLLATE utf8_general_ci,
						  `note` varchar(255) DEFAULT NULL,
						  `comments` text CHARACTER SET utf8 COLLATE utf8_general_ci,
						  `approved_by` int DEFAULT NULL,
						  `status` tinyint(1) NOT NULL DEFAULT '1',
						  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						  PRIMARY KEY (`id`),
						  KEY `student_fees_master_id` (`fees_allocation_id`),
						  KEY `fee_groups_feetype_id` (`fees_type_id`),
						  KEY `offline_fees_payments_ibfk_4` (`approved_by`),
						  KEY `student_session_id` (`student_enroll_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
						
    	$this->db->query("CREATE TABLE IF NOT EXISTS `offline_payment_types` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `note` varchar(500) DEFAULT NULL,
						  `branch_id` int NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
						
    	$this->db->query("CREATE TABLE IF NOT EXISTS `addon` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `prefix` varchar(255) NOT NULL,
						  `version` varchar(100) NOT NULL,
						  `purchase_code` varchar(255) DEFAULT NULL,
						  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
						
    	$this->db->query("CREATE TABLE IF NOT EXISTS `disable_reason` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `branch_id` int NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
						
    	$this->db->query("CREATE TABLE IF NOT EXISTS `disable_reason_details` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `student_id` int NOT NULL,
						  `reason_id` int NOT NULL,
						  `note` varchar(255) NOT NULL,
						  `date` date NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    	$this->db->query("CREATE TABLE IF NOT EXISTS `modules_manage` (
						  `id` int NOT NULL AUTO_INCREMENT,
						  `modules_id` int NOT NULL,
						  `isEnabled` tinyint(1) NOT NULL,
						  `branch_id` int NOT NULL,
						  PRIMARY KEY (`id`),
						  KEY `id` (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");						
						
		$this->db->query("ALTER TABLE `branch` ADD `translation` varchar(255) NOT NULL DEFAULT 'english' AFTER `due_with_fine`;");
		$this->db->query("ALTER TABLE `branch` ADD `timezone` varchar(255) NOT NULL AFTER `translation`;");
		$this->db->query("ALTER TABLE `branch` ADD `offline_payments` tinyint(1) NOT NULL DEFAULT '1' AFTER `timezone`;");
		$this->db->query("ALTER TABLE `branch` ADD `status` tinyint(1) NOT NULL DEFAULT '1' AFTER `offline_payments`;");
		
		
		$this->db->query("ALTER TABLE `front_cms_home` ADD `color1` varchar(100) DEFAULT NULL AFTER `elements`;");
		$this->db->query("ALTER TABLE `front_cms_home` ADD `color2` varchar(100) DEFAULT NULL AFTER `color1`;");
		
		$this->db->query("ALTER TABLE `permission_modules` ADD `in_module` tinyint(1) NOT NULL DEFAULT '1' AFTER `sorted`;");
		$this->db->query("TRUNCATE TABLE `permission_modules`;");
		$this->db->query("INSERT INTO `permission_modules` (`id`, `name`, `prefix`, `system`, `sorted`, `in_module`, `created_at`) VALUES
						(1, 'Dashboard', 'dashboard', 1, 1, 0, '2019-05-26 22:23:00'),
						(2, 'Student', 'student', 1, 4, 0, '2019-05-26 22:23:00'),
						(3, 'Parents', 'parents', 1, 5, 0, '2019-05-26 22:23:00'),
						(4, 'Employee', 'employee', 1, 6, 0, '2019-05-26 22:23:00'),
						(5, 'Human Resource', 'human_resource', 1, 9, 1, '2019-05-26 22:23:00'),
						(6, 'Academic', 'academic', 1, 10, 0, '2019-05-26 22:23:00'),
						(7, 'Homework', 'homework', 1, 13, 1, '2019-05-26 22:23:00'),
						(8, 'Attachments Book', 'attachments_book', 1, 12, 1, '2019-05-26 22:23:00'),
						(9, 'Exam Master', 'exam_master', 1, 14, 0, '2019-05-26 22:23:00'),
						(10, 'Hostel', 'hostel', 1, 16, 1, '2019-05-26 22:23:00'),
						(11, 'Transport', 'transport', 1, 17, 1, '2019-05-26 22:23:00'),
						(12, 'Attendance', 'attendance', 1, 18, 1, '2019-05-26 22:23:00'),
						(13, 'Library', 'library', 1, 19, 1, '2019-05-26 22:23:00'),
						(14, 'Events', 'events', 1, 20, 1, '2019-05-26 22:23:00'),
						(15, 'Bulk Sms And Email', 'bulk_sms_and_email', 1, 21, 1, '2019-05-26 22:23:00'),
						(16, 'Student Accounting', 'student_accounting', 1, 22, 1, '2019-05-26 22:23:00'),
						(17, 'Office Accounting', 'office_accounting', 1, 23, 1, '2019-05-26 22:23:00'),
						(18, 'Settings', 'settings', 1, 24, 0, '2019-05-26 22:23:00'),
						(19, 'Live Class', 'live_class', 1, 11, 1, '2019-05-26 22:23:00'),
						(20, 'Certificate', 'certificate', 1, 8, 1, '2019-05-26 22:23:00'),
						(21, 'Card Management', 'card_management', 1, 7, 1, '2019-05-26 22:23:00'),
						(22, 'Website', 'website', 1, 2, 1, '2019-05-26 22:23:00'),
						(23, 'Online Exam', 'online_exam', 1, 15, 1, '2019-05-26 22:23:00'),
						(24, 'Reception', 'reception', 1, 3, 1, '2019-05-26 22:23:00');");
		
		$this->db->query("ALTER TABLE `front_cms_setting` ADD `google_analytics` text AFTER `working_hours`;");
		$this->db->query("ALTER TABLE `front_cms_setting` ADD `primary_color` varchar(100) NOT NULL DEFAULT '#ff685c' AFTER `google_analytics`;");
		$this->db->query("ALTER TABLE `front_cms_setting` ADD `menu_color` varchar(100) NOT NULL DEFAULT '#fff' AFTER `primary_color`;");
		$this->db->query("ALTER TABLE `front_cms_setting` ADD `hover_color` varchar(100) NOT NULL DEFAULT '#f04133' AFTER `menu_color`;");
		$this->db->query("ALTER TABLE `front_cms_setting` ADD `text_color` varchar(100) NOT NULL DEFAULT '#232323' AFTER `hover_color`;");
		$this->db->query("ALTER TABLE `front_cms_setting` ADD `text_secondary_color` varchar(100) NOT NULL DEFAULT '#383838' AFTER `text_color`;");
		$this->db->query("ALTER TABLE `front_cms_setting` ADD `footer_background_color` varchar(100) NOT NULL DEFAULT '#383838' AFTER `text_secondary_color`;");
		$this->db->query("ALTER TABLE `front_cms_setting` ADD `footer_text_color` varchar(100) NOT NULL DEFAULT '#8d8d8d' AFTER `footer_background_color`;");
		$this->db->query("ALTER TABLE `front_cms_setting` ADD `copyright_bg_color` varchar(100) NOT NULL DEFAULT '#262626' AFTER `footer_text_color`;");
		$this->db->query("ALTER TABLE `front_cms_setting` ADD `copyright_text_color` varchar(100) NOT NULL DEFAULT '#8d8d8d' AFTER `copyright_bg_color`;");
		$this->db->query("ALTER TABLE `front_cms_setting` ADD `border_radius` varchar(100) NOT NULL DEFAULT '0' AFTER `copyright_text_color`;");
		
		$this->db->query("INSERT INTO `permission` (`id`, `module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`, `created_at`) VALUES
						(154, 2, 'Disable Reason', 'disable_reason', 1, 1, 1, 1, '2021-03-21 07:12:38'),
						(155, 16, 'Offline Payments', 'offline_payments', 1, 0, 0, 0, '2023-03-23 07:12:38'),
						(156, 16, 'Offline Payments Type', 'offline_payments_type', 1, 1, 1, 1, '2023-03-23 07:12:38');");
		
		$this->db->query("INSERT INTO `sms_api` (`id`, `name`) VALUES (8, 'customsms');");
		$this->db->where('id', '1')->update('front_cms_menu', ['alias' => '']);
    }
}
