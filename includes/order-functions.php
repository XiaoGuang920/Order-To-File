<?php
if (!defined('ABSPATH')) exit;

add_action('woocommerce_thankyou', 'write_order_to_file', 10, 1);

function write_order_to_file($order_id) {
    if (!get_option('order_to_file_enabled')) {
        return;
    }

    if (!$order_id) {
        return;
    }

    $order = wc_get_order($order_id);

    $order_data = array(
        'order_id'      => $order->get_id(),
        'order_date'    => $order->get_date_created()->date('Y-m-d H:i:s'),
        'billing_name'  => $order->get_formatted_billing_full_name(),
        'billing_email' => $order->get_billing_email(),
        'billing_phone' => $order->get_billing_phone(),
        'order_total'   => $order->get_total(),
        'order_items'   => array(),
    );

    foreach ($order->get_items() as $item_id => $item) {
        $product_name = $item->get_name();
        $quantity = $item->get_quantity();
        $total = $item->get_total();

        $order_data['order_items'][] = array(
            'product_name' => $product_name,
            'quantity'     => $quantity,
            'total'        => $total,
        );
    }

    $now = date('Y-m-d H:i:s');

    $order_data_json = json_encode($order_data);

    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['basedir'] . '/order-data.txt';

    $log_str = "[ {$now} ] {$order_data_json}";

    file_put_contents($file_path, $log_str . PHP_EOL, FILE_APPEND);
}

add_action('admin_notices', 'order_to_file_admin_notice');

function order_to_file_admin_notice() {
    if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('Settings saved successfully.', 'order-to-file'); ?></p>
        </div>
        <?php
    }
}
