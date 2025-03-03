<?php
/*
Plugin Name: byPieroFracasso WooCommerce Emails
Plugin URI: https://bypierofracasso.com/
Description: Steuert alle WooCommerce-E-Mails und deaktiviert nicht benötigte Standardmails.
Version: 1.0.1
Author: byPieroFracasso
Author URI: https://bypierofracasso.com/
License: GPLv2 or later
Text Domain: bypierofracasso-woocommerce-emails
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit; // Sicherheit: Direkter Zugriff verhindern
}

define('BYPF_EMAILS_VERSION', '1.0.0');

require_once plugin_dir_path(__FILE__) . 'includes/class-email-manager.php';
require_once plugin_dir_path(__FILE__) . 'templates/emails/setting-wc-email.php';

function bypierofracasso_woocommerce_emails_init() {
    new byPieroFracasso_Email_Manager();
}
add_action('plugins_loaded', 'bypierofracasso_woocommerce_emails_init');

add_filter('woocommerce_locate_template', 'bypierofracasso_override_woocommerce_emails', 10, 3);
function bypierofracasso_override_woocommerce_emails($template, $template_name, $template_path) {
    $plugin_path = plugin_dir_path(__FILE__) . 'templates/emails/';
    // Remove 'emails/' prefix if present
    $template_name = str_replace('emails/', '', $template_name);
    $custom_template = $plugin_path . $template_name;

    error_log("Template name requested: $template_name");
    error_log("Plugin path: $plugin_path");
    error_log("Custom template path: $custom_template");
    error_log("File exists: " . (file_exists($custom_template) ? 'Yes' : 'No'));

    if (file_exists($custom_template)) {
        error_log("Using custom template: $custom_template");
        return $custom_template;
    }
    error_log("Falling back to default template: $template");
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
    error_log("Email CSS: " . $css);
    echo '<style type="text/css">' . wp_strip_all_tags($css) . '</style>';
}

add_action('init', 'bypierofracasso_register_custom_order_statuses');
function bypierofracasso_register_custom_order_statuses() {
    register_post_status('wc-received', array(
        'label'                     => _x('Received', 'Order status', 'bypierofracasso-woocommerce-emails'),
        'public'                    => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Received <span class="count">(%s)</span>', 'Received <span class="count">(%s)</span>', 'bypierofracasso-woocommerce-emails'),
    ));

    register_post_status('wc-pending-payment', array(
        'label'                     => _x('Pending Payment', 'Order status', 'bypierofracasso-woocommerce-emails'),
        'public'                    => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Pending Payment <span class="count">(%s)</span>', 'Pending Payment <span class="count">(%s)</span>', 'bypierofracasso-woocommerce-emails'),
    ));

    register_post_status('wc-shipped', array(
        'label'                     => _x('Shipped', 'Order status', 'bypierofracasso-woocommerce-emails'),
        'public'                    => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>', 'bypierofracasso-woocommerce-emails'),
    ));

    register_post_status('wc-ready-for-pickup', array(
        'label'                     => _x('Ready for Pickup', 'Order status', 'bypierofracasso-woocommerce-emails'),
        'public'                    => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Ready for Pickup <span class="count">(%s)</span>', 'Ready for Pickup <span class="count">(%s)</span>', 'bypierofracasso-woocommerce-emails'),
    ));
}

add_filter('wc_order_statuses', 'bypierofracasso_add_custom_order_statuses');
function bypierofracasso_add_custom_order_statuses($order_statuses) {
    $order_statuses['wc-received'] = _x('Received', 'Order status', 'bypierofracasso-woocommerce-emails');
    $order_statuses['wc-pending-payment'] = _x('Pending Payment', 'Order status', 'bypierofracasso-woocommerce-emails');
    $order_statuses['wc-shipped'] = _x('Shipped', 'Order status', 'bypierofracasso-woocommerce-emails');
    $order_statuses['wc-ready-for-pickup'] = _x('Ready for Pickup', 'Order status', 'bypierofracasso-woocommerce-emails');
    return $order_statuses;
}

add_action('woocommerce_order_status_pending_to_received', 'bypierofracasso_trigger_received_email', 10, 2);
function bypierofracasso_trigger_received_email($order_id) {
    $email = WC()->mailer()->get_emails()['WC_Email_Order_Received'];
    if ($email && $email->is_enabled()) {
        $email->trigger($order_id);
    }
}

add_action('woocommerce_order_status_pending_to_pending-payment', 'bypierofracasso_trigger_pending_email', 10, 2);
function bypierofracasso_trigger_pending_email($order_id) {
    $email = WC()->mailer()->get_emails()['WC_Email_Pending_Order'];
    if ($email && $email->is_enabled()) {
        $email->trigger($order_id);
    }
}

add_action('woocommerce_order_status_processing_to_shipped', 'bypierofracasso_trigger_shipped_email', 10, 2);
function bypierofracasso_trigger_shipped_email($order_id) {
    $email = WC()->mailer()->get_emails()['WC_Email_Shipped_Order'];
    if ($email && $email->is_enabled()) {
        $email->trigger($order_id);
    }
}

add_action('woocommerce_order_status_processing_to_ready-for-pickup', 'bypierofracasso_trigger_ready_for_pickup_email', 10, 2);
function bypierofracasso_trigger_ready_for_pickup_email($order_id) {
    $email = WC()->mailer()->get_emails()['WC_Email_Ready_For_Pickup'];
    if ($email && $email->is_enabled()) {
        $email->trigger($order_id);
    }
}
