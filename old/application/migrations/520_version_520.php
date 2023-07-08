<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_520 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
    	$this->db->query("CREATE TABLE IF NOT EXISTS `online_exam` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `title` varchar(255) DEFAULT NULL,
						  `class_id` int(11) NOT NULL,
						  `section_id` text NOT NULL,
						  `subject_id` text NOT NULL,
						  `limits_participation` int(11) NOT NULL,
						  `exam_start` datetime DEFAULT NULL,
						  `exam_end` datetime DEFAULT NULL,
						  `duration` time NOT NULL,
						  `mark_type` tinyint(1) NOT NULL DEFAULT '1',
						  `passing_mark` float NOT NULL DEFAULT '0',
						  `instruction` text,
						  `session_id` int(11) DEFAULT NULL,
						  `publish_result` tinyint(1) NOT NULL DEFAULT '0',
						  `marks_display` tinyint(1) NOT NULL DEFAULT '1',
						  `neg_mark` tinyint(1) NOT NULL DEFAULT '0',
						  `question_type` tinyint(1) NOT NULL DEFAULT '0',
						  `publish_status` tinyint(1) NOT NULL DEFAULT '0',
						  `exam_type` tinyint(1) NOT NULL DEFAULT '0',
						  `fee` float NOT NULL DEFAULT '0',
						  `created_by` int(11) NOT NULL,
						  `branch_id` int(11) NOT NULL,
						  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						  `updated_at` date DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `session_id` (`session_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `online_exam_answer` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `student_id` int(11) NOT NULL,
						  `online_exam_id` int(11) NOT NULL,
						  `question_id` int(11) NOT NULL,
						  `answer` longtext,
						  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						  `updated_at` date DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `online_exam_attempts` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `student_id` int(11) NOT NULL,
						  `online_exam_id` int(11) NOT NULL,
						  `count` float NOT NULL DEFAULT '0',
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `online_exam_submitted` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `student_id` int(11) NOT NULL,
						  `online_exam_id` int(11) NOT NULL,
						  `created_at` datetime NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `promotion_history` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `student_id` int(11) NOT NULL,
						  `pre_class` int(11) NOT NULL,
						  `pre_section` int(11) NOT NULL,
						  `pre_session` int(11) NOT NULL,
						  `pro_class` int(11) NOT NULL,
						  `pro_section` int(11) NOT NULL,
						  `pro_session` int(11) NOT NULL,
						  `prev_due` float NOT NULL DEFAULT '0',
						  `date` datetime NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `questions` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `type` tinyint(1) NOT NULL,
						  `level` tinyint(1) NOT NULL,
						  `class_id` int(11) NOT NULL,
						  `section_id` int(11) DEFAULT '0',
						  `subject_id` int(11) NOT NULL DEFAULT '0',
						  `group_id` int(11) NOT NULL,
						  `question` text,
						  `opt_1` longtext,
						  `opt_2` longtext,
						  `opt_3` longtext,
						  `opt_4` longtext,
						  `answer` text,
						  `mark` float(10,2) NOT NULL DEFAULT '0.00',
						  `branch_id` int(11) NOT NULL,
						  `created_by` int(11) NOT NULL,
						  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						  `updated_at` date DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `questions_manage` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `question_id` int(11) DEFAULT NULL,
						  `onlineexam_id` int(11) DEFAULT NULL,
						  `marks` float(10,2) NOT NULL DEFAULT '0.00',
						  `neg_marks` float(10,2) DEFAULT '0.00',
						  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						  `updated_at` date DEFAULT NULL,
						  PRIMARY KEY (`id`),
						  KEY `onlineexam_id` (`onlineexam_id`),
						  KEY `question_id` (`question_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `question_group` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` longtext NOT NULL,
						  `branch_id` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    	$this->db->query("CREATE TABLE IF NOT EXISTS `student_profile_fields` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `fields_id` int(11) NOT NULL,
						  `status` tinyint(4) NOT NULL DEFAULT '1',
						  `required` tinyint(4) NOT NULL DEFAULT '0',
						  `branch_id` int(11) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    	$this->db->query("INSERT INTO `permission_modules` (`id`, `name`, `prefix`, `system`, `sorted`, `created_at`) VALUES (23, 'Online Exam', 'online_exam', 1, 22, '2019-05-26 22:23:00');");
    	$this->db->query("INSERT INTO `permission` (`module_id`, `name`, `prefix`, `show_view`, `show_add`, `show_edit`, `show_delete`, `created_at`) VALUES
						(23, 'Online Exam', 'online_exam', 1, 1, 1, 1, '2021-03-31 09:46:30'),
						(23, 'Question Bank', 'question_bank', 1, 1, 1, 1, '2021-03-31 09:46:30'),
						(23, 'Add Questions', 'add_questions', 0, 1, 0, 0, '2021-03-31 09:46:30'),
						(23, 'Question Group', 'question_group', 1, 1, 1, 1, '2021-03-31 09:46:30'),
						(23, 'Exam Result', 'exam_result', 1, 0, 0, 0, '2021-03-31 09:46:30');");
    	$this->db->query("INSERT INTO `staff_privileges` (`role_id`, `permission_id`, `is_add`, `is_edit`, `is_view`, `is_delete`) VALUES 
						(2, 136, 1, 1, 1, 1),
						(2, 137, 1, 1, 1, 1),
						(2, 138, 1, 0, 0, 0),
						(2, 139, 1, 1, 1, 1),
						(2, 140, 0, 0, 1, 0),
						(2, 135, 0, 1, 1, 0),
						(3, 131, 0, 0, 0, 0),
						(3, 132, 0, 0, 0, 0),
						(3, 129, 0, 0, 0, 0),
						(3, 130, 0, 0, 0, 0),
						(3, 136, 1, 1, 1, 1),
						(3, 137, 1, 1, 1, 1),
						(3, 138, 1, 0, 0, 0),
						(3, 139, 1, 1, 1, 1),
						(3, 140, 0, 0, 1, 0),
						(3, 134, 0, 0, 0, 0),
						(3, 135, 0, 0, 0, 0);");
    	$this->db->query("INSERT INTO `student_fields` (`prefix`, `default_status`, `default_required`, `created_at`) VALUES ('first_name', 1, 1, '2022-04-25 20:27:04');");
    	$this->db->query("ALTER TABLE `sms_template_details` ADD `dlt_template_id` varchar(255) DEFAULT NULL AFTER `template_id`;");
    	$this->db->query("ALTER TABLE `message` MODIFY `created_at` datetime NOT NULL;");
    	$this->db->query("ALTER TABLE `message` MODIFY `updated_at` datetime NOT NULL;");
    	$this->db->query("ALTER TABLE `message_reply` MODIFY `created_at` datetime NOT NULL;");
    }
}
