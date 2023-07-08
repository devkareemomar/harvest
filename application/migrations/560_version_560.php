<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_560 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {	
		$this->db->query("ALTER TABLE `global_settings` ADD `footer_branch_switcher` tinyint(1) NOT NULL DEFAULT '1' AFTER `preloader_backend`;");

        $config_path = APPPATH . 'config/config.php';
        $config_file = file_get_contents($config_path);
        $config_file = trim($config_file);
        $config_file = str_replace("\$config['csrf_protection'] == TRUE && isset(\$_SERVER['REQUEST_URI']) && (strpos(\$_SERVER['REQUEST_URI'],'feespayment/') !== FALSE || strpos(\$_SERVER['REQUEST_URI'],'admissionpayment/') !== FALSE || strpos(\$_SERVER['REQUEST_URI'],'onlineexam_payment/') !== FALSE)", "\$config['csrf_protection'] == TRUE && isset(\$_SERVER['REQUEST_URI']) && (strpos(\$_SERVER['REQUEST_URI'],'feespayment/') !== FALSE || strpos(\$_SERVER['REQUEST_URI'],'admissionpayment/') !== FALSE || strpos(\$_SERVER['REQUEST_URI'],'onlineexam_payment/') !== FALSE || strpos(\$_SERVER['REQUEST_URI'],'subscription/') !== FALSE || strpos(\$_SERVER['REQUEST_URI'], 'saas_payment/') !== FALSE)", $config_file);
        $handle = fopen($config_path, 'w+');
        @chmod($config_path, 0777);
        fwrite($handle, $config_file);
        fclose($handle);
    }
}
