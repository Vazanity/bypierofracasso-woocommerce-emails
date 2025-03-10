<?php
/*
Plugin Name: byPieroFracasso WooCommerce Emails
Plugin URI: https://bypierofracasso.com/
Description: Steuert alle WooCommerce-E-Mails und deaktiviert nicht benötigte Standardmails.
Version: 1.0.16
Author: byPieroFracasso
Author URI: https://bypierofracasso.com/
License: GPLv2 or later
Text Domain: bypierofracasso-woocommerce-emails
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit;
}

define('BYPF_EMAILS_VERSION', '1.0.5');

require_once plugin_dir_path(__FILE__) . 'includes/class-email-manager.php';
require_once plugin_dir_path(__FILE__) . 'templates/emails/setting-wc-email.php';

function bypierofracasso_woocommerce_emails_init() {
    new byPieroFracasso_Email_Manager();
}
add_action('plugins_loaded', 'bypierofracasso_woocommerce_emails_init');

// Debug: Confirm plugin is active on admin page loads
add_action('admin_init', 'bypierofracasso_debug_plugin_active');
function bypierofracasso_debug_plugin_active() {
    error_log("byPieroFracasso WooCommerce Emails plugin (v" . BYPF_EMAILS_VERSION . ") is active on admin page load.");
}

// Debug: Log order save at the WordPress level
add_action('save_post_shop_order', 'bypierofracasso_debug_save_post', 10, 3);
function bypierofracasso_debug_save_post($post_id, $post, $update) {
    if ($update) {
        error_log("Order $post_id updated via save_post_shop_order hook");
        $order = wc_get_order($post_id);
        if ($order) {
            $old_status = get_post_meta($post_id, '_status_before_update', true) ?: $order->get_status();
            $new_status = $order->get_status();
            error_log("Order $post_id - Old status (meta): $old_status, New status: $new_status");
            update_post_meta($post_id, '_status_before_update', $new_status);
        }
    }
}

// Explicitly trigger custom emails upon status change using specific hooks
add_action('woocommerce_order_status_wc-shipped', 'bypierofracasso_trigger_shipped_email', 10, 1);
function bypierofracasso_trigger_shipped_email($order_id) {
    error_log("Order $order_id transitioned to wc-shipped (via woocommerce_order_status_wc-shipped hook)");
    $mailer = WC()->mailer()->get_emails();
    if (!empty($mailer['WC_Email_Shipped_Order'])) {
        error_log("Triggering WC_Email_Shipped_Order for order $order_id");
        $mailer['WC_Email_Shipped_Order']->trigger($order_id);
        error_log("Send result for WC_Email_Shipped_Order for order $order_id: Attempted");
    } else {
        error_log("WC_Email_Shipped_Order not found in mailer for order $order_id");
    }
}

add_action('woocommerce_order_status_wc-ready-for-pickup', 'bypierofracasso_trigger_ready_for_pickup_email', 10, 1);
function bypierofracasso_trigger_ready_for_pickup_email($order_id) {
    error_log("Order $order_id transitioned to wc-ready-for-pickup (via woocommerce_order_status_wc-ready-for-pickup hook)");
    $mailer = WC()->mailer()->get_emails();
    if (!empty($mailer['WC_Email_Ready_For_Pickup'])) {
        error_log("Triggering WC_Email_Ready_For_Pickup for order $order_id");
        $mailer['WC_Email_Ready_For_Pickup']->trigger($order_id);
        error_log("Send result for WC_Email_Ready_For_Pickup for order $order_id: Attempted");
    } else {
        error_log("WC_Email_Ready_For_Pickup not found in mailer for order $order_id");
    }
}

// Fallback: Trigger emails using woocommerce_order_status_changed hook
add_action('woocommerce_order_status_changed', 'bypierofracasso_fallback_trigger_custom_status_emails', 10, 4);
function bypierofracasso_fallback_trigger_custom_status_emails($order_id, $old_status, $new_status, $order) {
    error_log("Order $order_id status changed from $old_status to $new_status (via woocommerce_order_status_changed hook)");
    $mailer = WC()->mailer()->get_emails();

    if ($new_status === 'wc-shipped' && !empty($mailer['WC_Email_Shipped_Order'])) {
        error_log("Fallback: Triggering WC_Email_Shipped_Order for order $order_id");
        $mailer['WC_Email_Shipped_Order']->trigger($order_id);
        error_log("Fallback: Send result for WC_Email_Shipped_Order for order $order_id: Attempted");
    } elseif ($new_status === 'wc-ready-for-pickup' && !empty($mailer['WC_Email_Ready_For_Pickup'])) {
        error_log("Fallback: Triggering WC_Email_Ready_For_Pickup for order $order_id");
        $mailer['WC_Email_Ready_For_Pickup']->trigger($order_id);
        error_log("Fallback: Send result for WC_Email_Ready_For_Pickup for order $order_id: Attempted");
    }
}

// Debug: Log before order save
add_action('woocommerce_before_order_object_save', 'bypierofracasso_debug_before_save', 999, 2);
function bypierofracasso_debug_before_save($order, $data_store) {
    error_log("woocommerce_before_order_object_save hook fired for order {$order->get_id()}");
    if ($order->get_id()) {
        $old_status = $order->get_status('edit');
        $new_status = isset($order->data['status']) ? $order->data['status'] : $old_status;
        error_log("Order {$order->get_id()} - Old status: $old_status, New status: $new_status");
        if ($old_status !== $new_status) {
            error_log("Order {$order->get_id()} status changing from $old_status to $new_status (before save)");
        } else {
            error_log("Order {$order->get_id()} - No status change detected (old: $old_status, new: $new_status)");
        }
    } else {
        error_log("Order object has no ID in woocommerce_before_order_object_save");
    }
}

// Debug: Log after order save
add_action('woocommerce_after_order_object_save', 'bypierofracasso_debug_after_save', 999, 2);
function bypierofracasso_debug_after_save($order, $data_store) {
    error_log("woocommerce_after_order_object_save hook fired for order {$order->get_id()}");
    $status = $order->get_status();
    error_log("Order {$order->get_id()} - Status after save: $status");
}

add_filter('woocommerce_locate_template', 'bypierofracasso_override_woocommerce_emails', 10, 3);
function bypierofracasso_override_woocommerce_emails($template, $template_name, $template_path) {
    $plugin_path = plugin_dir_path(__FILE__) . 'templates/emails/';
    $template_name = str_replace('emails/', '', $template_name);
    $custom_template = $plugin_path . $template_name;

    if (file_exists($custom_template)) {
        return $custom_template;
    }
    return $template;
}

add_action('plugins_loaded', 'bypierofracasso_load_textdomain');
function bypierofracasso_load_textdomain() {
    load_plugin_textdomain('bypierofracasso-woocommerce-emails', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

add_action('woocommerce_email_header', 'bypierofracasso_add_email_styles', 20);
function bypierofracasso_add_email_styles($email) {
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/emails/email-styles.php';
    $css = ob_get_clean();
    echo '<style type="text/css">' . wp_strip_all_tags($css) . '</style>';
}

// Register Custom Order Statuses using Modern WooCommerce Hook
add_filter('woocommerce_register_shop_order_post_statuses', 'bypierofracasso_register_custom_statuses');
function bypierofracasso_register_custom_statuses($statuses) {
    $statuses['wc-received'] = array(
        'label'                     => _x('Received', 'Order status', 'bypierofracasso-woocommerce-emails'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Received <span class="count">(%s)</span>', 'Received <span class="count">(%s)</span>', 'bypierofracasso-woocommerce-emails'),
    );
    $statuses['wc-pending-payment'] = array(
        'label'                     => _x('Pending Payment', 'Order status', 'bypierofracasso-woocommerce-emails'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Pending Payment <span class="count">(%s)</span>', 'Pending Payment <span class="count">(%s)</span>', 'bypierofracasso-woocommerce-emails'),
    );
    $statuses['wc-shipped'] = array(
        'label'                     => _x('Shipped', 'Order status', 'bypierofracasso-woocommerce-emails'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>', 'bypierofracasso-woocommerce-emails'),
    );
    $statuses['wc-ready-for-pickup'] = array(
        'label'                     => _x('Ready for Pickup', 'Order status', 'bypierofracasso-woocommerce-emails'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Ready for Pickup <span class="count">(%s)</span>', 'Ready for Pickup <span class="count">(%s)</span>', 'bypierofracasso-woocommerce-emails'),
    );
    return $statuses;
}

add_filter('wc_order_statuses', 'bypierofracasso_add_custom_order_statuses');
function bypierofracasso_add_custom_order_statuses($order_statuses) {
    $order_statuses['wc-received'] = _x('Received', 'Order status', 'bypierofracasso-woocommerce-emails');
    $order_statuses['wc-pending-payment'] = _x('Pending Payment', 'Order status', 'bypierofracasso-woocommerce-emails');
    $order_statuses['wc-shipped'] = _x('Shipped', 'Order status', 'bypierofracasso-woocommerce-emails');
    $order_statuses['wc-ready-for-pickup'] = _x('Ready for Pickup', 'Order status', 'bypierofracasso-woocommerce-emails');
    return $order_statuses;
}

// Ensure Bulk Actions Recognize Custom Statuses
add_filter('bulk_actions-edit-shop_order', 'bypierofracasso_add_bulk_order_statuses');
function bypierofracasso_add_bulk_order_statuses($actions) {
    $actions['mark_wc-shipped'] = __('Change status to Shipped', 'bypierofracasso-woocommerce-emails');
    $actions['mark_wc-ready-for-pickup'] = __('Change status to Ready for Pickup', 'bypierofracasso-woocommerce-emails');
    return $actions;
}

// Set Initial Status to "Received" After Payment
add_action('woocommerce_payment_complete', 'bypierofracasso_set_initial_received_status', 20, 1);
function bypierofracasso_set_initial_received_status($order_id) {
    $order = wc_get_order($order_id);
    if ($order && !$order->has_status('wc-received')) {
        error_log("Setting order $order_id to wc-received after payment");
        $order->update_status('wc-received', __('Order set to Received after payment.', 'bypierofracasso-woocommerce-emails'));
        $email = WC()->mailer()->get_emails()['WC_Email_Order_Received'];
        if ($email && $email->is_enabled()) {
            $email->trigger($order_id);
        }
    }
}

// Manual Trigger for Debugging
add_action('admin_init', 'bypierofracasso_manual_email_trigger');
function bypierofracasso_manual_email_trigger() {
    if (isset($_GET['bypf_trigger_email']) && current_user_can('manage_woocommerce')) {
        $order_id = intval($_GET['bypf_trigger_email']);
        $order = wc_get_order($order_id);
        if ($order) {
            $status = $order->get_status();
            error_log("Manual trigger attempt for order $order_id with status $status");
            if ($status === 'wc-shipped') {
                $email = WC()->mailer()->get_emails()['WC_Email_Shipped_Order'];
                error_log("Checking WC_Email_Shipped_Order: " . ($email ? 'Found' : 'Not found') . ", Enabled: " . ($email && $email->is_enabled() ? 'Yes' : 'No'));
                if ($email && $email->is_enabled()) {
                    error_log("Triggering WC_Email_Shipped_Order for order $order_id");
                    $email->trigger($order_id);
                    error_log("Send result for WC_Email_Shipped_Order for order $order_id: Attempted");
                } else {
                    error_log("WC_Email_Shipped_Order not found or not enabled for manual trigger of order $order_id");
                }
            } elseif ($status === 'wc-ready-for-pickup') {
                $email = WC()->mailer()->get_emails()['WC_Email_Ready_For_Pickup'];
                error_log("Checking WC_Email_Ready_For_Pickup: " . ($email ? 'Found' : 'Not found') . ", Enabled: " . ($email && $email->is_enabled() ? 'Yes' : 'No'));
                if ($email && $email->is_enabled()) {
                    error_log("Triggering WC_Email_Ready_For_Pickup for order $order_id");
                    $email->trigger($order_id);
                    error_log("Send result for WC_Email_Ready_For_Pickup for order $order_id: Attempted");
                } else {
                    error_log("WC_Email_Ready_For_Pickup not found or not enabled for manual trigger of order $order_id");
                }
            } else {
                error_log("Order $order_id has unsupported status $status for manual trigger");
            }
        } else {
            error_log("Manual trigger failed: Order $order_id not found");
        }
    }
}
