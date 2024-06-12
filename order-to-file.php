<?php
/**
 * @package Order to File
 * @version 1.0.0
 * 
 * Plugin Name: Order to File
 * Description: Help you to write your order into file automatically.
 * Author: Aaron Wang
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) exit();

add_action('plugins_loaded', 'order_to_file_load_textdomain');

function order_to_file_load_textdomain() {
    load_plugin_textdomain('order-to-file', false, dirname(plugin_basename(__FILE__)) . '/languages/zh-tw');
}

require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/order-functions.php';
