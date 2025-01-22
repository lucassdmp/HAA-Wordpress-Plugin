<?php

/**
 * Plugin Name: Helene Abiassy - Plugin
 * Plugin URI: https://www.heleneabiassi.academy/
 * Description: Plugin para o site Helene Abiassy Academy
 * Version: 1.0.0.4
 * Author: VPTEC
 */

if (!defined('ABSPATH')) {
    exit;
}


require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';


use HAAPlugin\HeleneAbiassyAcademy;

$HAA_instance = HeleneAbiassyAcademy::get_instance();

