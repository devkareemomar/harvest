<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_530 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
    	$this->db->query("CREATE TABLE IF NOT EXISTS `call_log` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) DEFAULT NULL,
						  `number` varchar(255) DEFAULT NULL,
						  `purpose_id` int(11) DEFAULT NULL,
						  `call_type` tinyint(1) DEFAULT NULL,
						  `date` date NOT NULL,
						  `start_time` time DEFAULT NULL,
						  `end_time` time DEFAULT NULL,
						  `follow_up` date DEFAULT NULL,
						  `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						  `branch_id` int(11) NOT NULL,
						  `created_by` int(11) NOT NULL,
						  `created_at` datetime NOT NULL,
						  `updated_at` datetime DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `call_purpose` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `branch_id` int(11) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `complaint` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) DEFAULT NULL,
						  `number` varchar(255) DEFAULT NULL,
						  `type_id` int(11) DEFAULT NULL,
						  `date` date NOT NULL,
						  `assigned_id` int(11) DEFAULT NULL,
						  `action` varchar(255) NOT NULL,
						  `date_of_solution` date DEFAULT NULL,
						  `file` varchar(500) NOT NULL,
						  `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						  `branch_id` int(11) NOT NULL,
						  `created_by` int(11) NOT NULL,
						  `created_at` datetime NOT NULL,
						  `updated_at` datetime DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `complaint_type` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `branch_id` int(11) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `enquiry` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `birthday` date DEFAULT NULL,
						  `gender` tinyint(1) DEFAULT '0',
						  `father_name` varchar(255) DEFAULT NULL,
						  `mother_name` varchar(255) DEFAULT NULL,
						  `mobile_no` varchar(255) NOT NULL,
						  `email` varchar(255) NOT NULL,
						  `address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						  `previous_school` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						  `reference_id` int(11) NOT NULL,
						  `response_id` int(11) NOT NULL,
						  `response` varchar(255) NOT NULL,
						  `date` date NOT NULL,
						  `note` varchar(255) NOT NULL,
						  `assigned_id` int(11) NOT NULL,
						  `created_by` int(11) NOT NULL,
						  `no_of_child` float NOT NULL,
						  `class_id` int(11) NOT NULL,
						  `status` tinyint(1) NOT NULL DEFAULT '1',
						  `branch_id` int(11) NOT NULL,
						  `created_at` date NOT NULL,
						  `updated_at` date DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `enquiry_follow_up` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `enquiry_id` int(11) NOT NULL,
						  `date` date NOT NULL,
						  `next_date` date NOT NULL,
						  `response` varchar(255) DEFAULT NULL,
						  `status` tinyint(1) NOT NULL,
						  `note` varchar(255) NOT NULL,
						  `follow_up_by` int(11) NOT NULL,
						  `created_at` date NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `enquiry_reference` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `branch_id` int(11) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `enquiry_response` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `branch_id` int(11) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `online_exam_payment` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `student_id` int(11) NOT NULL,
						  `exam_id` int(11) NOT NULL,
						  `payment_method` tinyint(4) NOT NULL,
						  `amount` float NOT NULL DEFAULT '0',
						  `transaction_id` varchar(500) NOT NULL,
						  `created_at` datetime NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `postal_record` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `sender_title` varchar(255) DEFAULT NULL,
						  `receiver_title` varchar(255) DEFAULT NULL,
						  `reference_no` varchar(255) DEFAULT NULL,
						  `address` text NOT NULL,
						  `date` date NOT NULL,
						  `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						  `file` varchar(250) NOT NULL,
						  `confidential` tinyint(1) NOT NULL DEFAULT '0',
						  `created_by` int(11) NOT NULL,
						  `type` tinyint(1) NOT NULL DEFAULT '1',
						  `branch_id` int(11) NOT NULL,
						  `created_at` datetime NOT NULL,
						  `updated_at` datetime DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `visitor_log` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) DEFAULT NULL,
						  `number` varchar(255) DEFAULT NULL,
						  `purpose_id` int(11) DEFAULT NULL,
						  `date` date NOT NULL,
						  `entry_time` time DEFAULT NULL,
						  `exit_time` time DEFAULT NULL,
						  `number_of_visitor` float DEFAULT NULL,
						  `id_number` varchar(255) DEFAULT NULL,
						  `token_pass` varchar(255) DEFAULT NULL,
						  `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
						  `branch_id` int(11) NOT NULL,
						  `created_by` int(11) NOT NULL,
						  `created_at` datetime NOT NULL,
						  `updated_at` datetime DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `visitor_purpose` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` varchar(255) NOT NULL,
						  `branch_id` int(11) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
						
		$this->db->query("ALTER TABLE `online_exam_submitted` ADD `remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL AFTER `online_exam_id`;");
		$this->db->query("ALTER TABLE `online_exam_submitted` ADD `position` int(11) NOT NULL AFTER `remark`;");
		$this->db->query("ALTER TABLE `online_exam` ADD `position_generated` tinyint(1) NOT NULL DEFAULT '0' AFTER `created_by`;");

		$this->db->query("TRUNCATE TABLE `sms_api`;");
    	$this->db->query("INSERT INTO `sms_api` (`id`, `name`) VALUES (1, 'twilio'), (2, 'clickatell'), (3, 'msg91'), (4, 'bulksms'), (5, 'textlocal'), (6, 'smscountry'), (7, 'bulksmsbd');");
		
		$this->db->query("TRUNCATE TABLE `sms_template`;");
		$this->db->query("INSERT INTO `sms_template` (`id`, `name`, `tags`) VALUES
						(1, 'admission', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}'),
						(2, 'fee_collection', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {paid_amount}, {paid_date} '),
						(3, 'attendance', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}'),
						(4, 'exam_attendance', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {exam_name}, {term_name}, {subject}'),
						(5, 'exam_results', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {exam_name}, {term_name}, {subject}, {marks}'),
						(6, 'homework', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {subject}, {date_of_homework}, {date_of_submission}'),
						(7, 'live_class', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {date_of_live_class}, {start_time}, {end_time}, {host_by}'),
						(8, 'online_exam_publish', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {exam_title}, {start_time}, {end_time}, {time_duration}, {attempt}, {passing_mark}, {exam_fee}'),
						(9, 'student_birthday_wishes', '{name}, {class}, {section}, {admission_date}, {roll}, {register_no}, {birthday}'),
						(10, 'staff_birthday_wishes', '{name}, {birthday}, {joining_date}');");
    	$this->db->query("INSERT INTO `permission_modules` (`id`, `name`, `prefix`, `system`, `sorted`, `created_at`) VALUES (24, 'Reception', 'reception', 1, 23, '2019-05-26 22:23:00');");
		$this->db->query("INSERT INTO `permission` (`id`, `module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`, `created_at`) VALUES
						(141, 23, 'Position Generate', 'position_generate', 1, 1, 0, 0, '2021-03-31 09:46:30'),
						(142, 24, 'Postal Record', 'postal_record', 1, 1, 1, 1, '2021-03-31 09:46:30'),
						(143, 24, 'Call Log', 'call_log', 1, 1, 1, 1, '2021-03-31 09:46:30'),
						(144, 24, 'Visitor Log', 'visitor_log', 1, 1, 1, 1, '2021-03-31 09:46:30'),
						(145, 24, 'Complaint', 'complaint', 1, 1, 1, 1, '2021-03-31 09:46:30'),
						(146, 24, 'Enquiry', 'enquiry', 1, 1, 1, 1, '2021-03-31 09:46:30'),
						(147, 24, 'Follow Up', 'follow_up', 1, 1, 0, 1, '2021-03-31 09:46:30'),
						(148, 24, 'Config Reception', 'config_reception', 1, 1, 1, 1, '2021-03-31 09:46:30'),
						(149, 15, 'Student Birthday Wishes', 'student_birthday_wishes', 1, 0, 0, 0, '2021-03-31 09:46:30'),
						(150, 15, 'Staff Birthday Wishes', 'staff_birthday_wishes', 1, 0, 0, 0, '2021-03-31 09:46:30'),
						(151, 1, 'Student Birthday Wishes Widget', 'student_birthday_widget', 1, 0, 0, 0, '2021-03-31 07:22:05'),
						(152, 1, 'Staff Birthday Wishes Widget', 'staff_birthday_widget', 1, 0, 0, 0, '2021-03-31 07:22:05'),
						(153, 9, 'Progress Reports', 'progress_reports', 1, 0, 0, 0, '2021-03-21 07:12:38');");
		$this->db->query("INSERT INTO `roles` (`name`, `prefix`, `is_system`) VALUES ('Receptionist', 'receptionist', '1');");
		
		$this->db->query("ALTER TABLE `questions` CHANGE `question` `question` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
		$this->db->query("ALTER TABLE `questions` CHANGE `opt_1` `opt_1` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
		$this->db->query("ALTER TABLE `questions` CHANGE `opt_2` `opt_2` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
		$this->db->query("ALTER TABLE `questions` CHANGE `opt_3` `opt_3` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
		$this->db->query("ALTER TABLE `questions` CHANGE `opt_4` `opt_4` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
		$this->db->query("ALTER TABLE `questions` CHANGE `answer` `answer` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");

		$this->db->where('prefix', 'dashboard')->update('permission_modules', ['sorted' => 1]);
		$this->db->where('prefix', 'website')->update('permission_modules', ['sorted' => 2]);
		$this->db->where('prefix', 'reception')->update('permission_modules', ['sorted' => 3]);
		$this->db->where('prefix', 'student')->update('permission_modules', ['sorted' => 4]);
		$this->db->where('prefix', 'parents')->update('permission_modules', ['sorted' => 5]);
		$this->db->where('prefix', 'employee')->update('permission_modules', ['sorted' => 6]);
		$this->db->where('prefix', 'card_management')->update('permission_modules', ['sorted' => 7]);
		$this->db->where('prefix', 'certificate')->update('permission_modules', ['sorted' => 8]);
		$this->db->where('prefix', 'human_resource')->update('permission_modules', ['sorted' => 9]);
		$this->db->where('prefix', 'academic')->update('permission_modules', ['sorted' => 10]);
		$this->db->where('prefix', 'live_class')->update('permission_modules', ['sorted' => 11]);
		$this->db->where('prefix', 'attachments_book')->update('permission_modules', ['sorted' => 12]);
		$this->db->where('prefix', 'homework')->update('permission_modules', ['sorted' => 13]);
		$this->db->where('prefix', 'exam_master')->update('permission_modules', ['sorted' => 14]);
		$this->db->where('prefix', 'online_exam')->update('permission_modules', ['sorted' => 15]);
		$this->db->where('prefix', 'hostel')->update('permission_modules', ['sorted' => 16]);
		$this->db->where('prefix', 'transport')->update('permission_modules', ['sorted' => 17]);
		$this->db->where('prefix', 'attendance')->update('permission_modules', ['sorted' => 18]);
		$this->db->where('prefix', 'library')->update('permission_modules', ['sorted' => 19]);
		$this->db->where('prefix', 'events')->update('permission_modules', ['sorted' => 20]);
		$this->db->where('prefix', 'bulk_sms_and_email')->update('permission_modules', ['sorted' => 21]);
		$this->db->where('prefix', 'student_accounting')->update('permission_modules', ['sorted' => 22]);
		$this->db->where('prefix', 'office_accounting')->update('permission_modules', ['sorted' => 23]);
		$this->db->where('prefix', 'settings')->update('permission_modules', ['sorted' => 24]);
		
        $config_path = APPPATH . 'config/config.php';
        $config_file = file_get_contents($config_path);
        $config_file = trim($config_file);
		$config_file = str_replace("\$config['csrf_protection'] == TRUE && isset(\$_SERVER['REQUEST_URI']) && (strpos(\$_SERVER['REQUEST_URI'],'feespayment/') !== FALSE || strpos(\$_SERVER['REQUEST_URI'],'admissionpayment/') !== FALSE", "\$config['csrf_protection'] == TRUE && isset(\$_SERVER['REQUEST_URI']) && (strpos(\$_SERVER['REQUEST_URI'],'feespayment/') !== FALSE || strpos(\$_SERVER['REQUEST_URI'],'admissionpayment/') !== FALSE || strpos(\$_SERVER['REQUEST_URI'],'onlineexam_payment/') !== FALSE", $config_file);
		$handle = fopen($config_path, 'w+');
		@chmod($config_path, 0777);
		fwrite($handle, $config_file);
		fclose($handle);
    }
}
