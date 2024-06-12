<?php
if (!defined('ABSPATH')) exit;


add_action('admin_menu', 'order_to_file_menu');

function order_to_file_menu() {
    add_menu_page(
        'Order to File Settings',
        'Order to File',
        'manage_options',
        'order-to-file',
        'order_to_file_settings_page',
        'dashicons-clipboard',
        58
    );
}

function order_to_file_settings_page() {
    ?>
    <div class="wrap">
        <h1>Order to File Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('order_to_file_options_group');
            do_settings_sections('order-to-file');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'order_to_file_settings_init');

function order_to_file_settings_init() {
    register_setting('order_to_file_options_group', 'order_to_file_enabled');

    add_settings_section(
        'order_to_file_section',
        'Main Setting',
        null,
        'order-to-file'
    );

    add_settings_field(
        'order_to_file_enabled',
        'Enable Order to File',
        'order_to_file_enabled_callback',
        'order-to-file',
        'order_to_file_section'
    );
}

function order_to_file_enabled_callback() {
    $option = get_option('order_to_file_enabled');
    ?>
    <input type="checkbox" name="order_to_file_enabled" value="1" <?php checked(1, $option, true); ?>>
    <label for="order_to_file_enabled">Enable automatic order export to local file</label>
    <?php
}
