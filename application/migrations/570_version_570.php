<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_570 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {	
        $this->db->query("ALTER TABLE `student_attendance` CHANGE `student_id` `enroll_id` int NOT NULL;");
        $this->db->query("ALTER TABLE `email_config` ADD `smtp_auth` varchar(10) DEFAULT NULL AFTER `smtp_encryption`;");
        
        $this->db->query("ALTER TABLE `branch` ADD `weekends` varchar(255) NOT NULL DEFAULT '0' AFTER `timezone`;");
        $this->db->query("ALTER TABLE `branch` ADD `reg_prefix_enable` tinyint(1) NOT NULL DEFAULT '0' AFTER `weekends`;");
        $this->db->query("ALTER TABLE `branch` ADD `reg_start_from` tinyint NOT NULL DEFAULT '1' AFTER `reg_prefix_enable`;");
        $this->db->query("ALTER TABLE `branch` ADD `institution_code` varchar(100) DEFAULT NULL AFTER `reg_start_from`;");
        $this->db->query("ALTER TABLE `branch` ADD `reg_prefix_digit` int NOT NULL AFTER `institution_code`;");

        $this->db->query("ALTER TABLE `fees_reminder` ADD `dlt_template_id` varchar(255) DEFAULT NULL AFTER `message`;");
        $this->db->query("ALTER TABLE `event` ADD `session_id` int NOT NULL AFTER `created_by`;");
        
        $this->db->query("ALTER TABLE `payment_config` ADD `paytm_merchantmid` varchar(255) DEFAULT NULL AFTER `flutterwave_status`;");
        $this->db->query("ALTER TABLE `payment_config` ADD `paytm_merchantkey` varchar(255) DEFAULT NULL AFTER `paytm_merchantmid`;");
        $this->db->query("ALTER TABLE `payment_config` ADD `paytm_merchant_website` varchar(255) DEFAULT NULL AFTER `paytm_merchantkey`;");
        $this->db->query("ALTER TABLE `payment_config` ADD `paytm_industry_type` varchar(255) DEFAULT NULL AFTER `paytm_merchant_website`;");
        $this->db->query("ALTER TABLE `payment_config` ADD `paytm_status` tinyint(1) NOT NULL DEFAULT '0' AFTER `paytm_industry_type`;");

        $this->db->query("ALTER TABLE `payment_config` ADD `toyyibpay_secretkey` varchar(255) DEFAULT NULL AFTER `paytm_status`;");
        $this->db->query("ALTER TABLE `payment_config` ADD `toyyibpay_categorycode` varchar(255) DEFAULT NULL AFTER `toyyibpay_secretkey`;");
        $this->db->query("ALTER TABLE `payment_config` ADD `toyyibpay_status` tinyint(1) NOT NULL DEFAULT '0' AFTER `toyyibpay_categorycode`;");

        $this->db->query("ALTER TABLE `payment_config` ADD `payhere_merchant_id` varchar(255) DEFAULT NULL AFTER `toyyibpay_status`;");
        $this->db->query("ALTER TABLE `payment_config` ADD `payhere_merchant_secret` varchar(255) DEFAULT NULL AFTER `payhere_merchant_id`;");
        $this->db->query("ALTER TABLE `payment_config` ADD `payhere_status` tinyint(1) NOT NULL DEFAULT '0' AFTER `payhere_merchant_secret`;");
        
        $this->db->query("TRUNCATE TABLE `payment_types`;");
        $this->db->query("INSERT INTO `payment_types` (`id`, `name`, `branch_id`, `timestamp`) VALUES
                            (1, 'Cash', 0, '2019-07-27 18:12:21'),
                            (2, 'Card', 0, '2019-07-27 18:12:31'),
                            (3, 'Cheque', 0, '2019-12-21 10:07:59'),
                            (4, 'Bank Transfer', 0, '2019-12-21 10:08:36'),
                            (5, 'Other', 0, '2019-12-21 10:08:45'),
                            (6, 'Paypal', 0, '2019-12-21 10:08:45'),
                            (7, 'Stripe', 0, '2019-12-21 10:08:45'),
                            (8, 'PayUmoney', 0, '2019-12-21 10:08:45'),
                            (9, 'Paystack', 0, '2019-12-21 10:08:45'),
                            (10, 'Razorpay', 0, '2019-12-21 10:08:45'),
                            (11, 'SSLcommerz', 0, '2022-05-21 10:08:45'),
                            (12, 'Jazzcash', 0, '2022-05-21 10:08:45'),
                            (13, 'Midtrans', 0, '2022-05-21 10:08:45'),
                            (14, 'Flutter Wave', 0, '2022-05-15 10:08:45'),
                            (15, 'Offline Payments', 0, '2022-05-15 10:08:45'),
                            (16, 'Paytm', 0, '2023-05-12 12:08:45'),
                            (17, 'toyyibPay', 0, '2023-05-12 12:08:45'),
                            (18, 'Payhere', 0, '2023-05-12 12:08:45');");


        $this->db->select('id');
        $this->db->where('date(end_date) <', "2023-12-31");
        $this->db->where('date(end_date) >', "2023-01-01");
        $r_event =  $this->db->get('event')->result();
        foreach ($r_event as $key => $value) {
            $this->db->where('id', $value->id);
            $this->db->update('event', ['session_id' => get_session_id()]);
        }

        $this->db->select('id,enroll_id');
        $this->db->where('date(date) <', "2023-12-31");
        $this->db->where('date(date) >', "2023-01-01");
        $r_attendance =  $this->db->get('student_attendance')->result();
        foreach ($r_attendance as $key => $value) {
            $e = $this->db->where(['student_id' => $value->enroll_id, 'session_id' => get_session_id()])->get('enroll')->row();
            if (!empty($e)) {
                $this->db->where('id', $value->id);
                $this->db->update('student_attendance', ['enroll_id' => $e->id]);
            }
        }

    }
}
