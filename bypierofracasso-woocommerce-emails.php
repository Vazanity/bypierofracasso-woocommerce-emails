<?php
/*
Plugin Name: Piero Fracasso Perfumes WooCommerce Emails
Plugin URI: https://bypierofracasso.com/
Description: Steuert alle WooCommerce-E-Mails und deaktiviert nicht benötigte Standardmails.

Version: 1.2.2

Author: Piero Fracasso Perfumes
Author URI: https://bypierofracasso.com/
License: GPLv2 or later
Text Domain: piero-fracasso-emails
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit;
}

define('BYPF_EMAILS_VERSION', '1.2.2');

function bypf_log($message, $level = 'debug')
{
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        return;
    }

    if (function_exists('wc_get_logger')) {
        wc_get_logger()->log($level, $message, array('source' => 'bypf-emails'));
    } elseif (function_exists('error_log')) {
        error_log('bypf-emails [' . $level . ']: ' . $message);
    } else {
        trigger_error('bypf-emails [' . $level . ']: ' . $message, E_USER_NOTICE);
    }
}

function bypf_emails_load_autoloader()
{
    $autoload = plugin_dir_path(__FILE__) . 'vendor/autoload.php';
    if (file_exists($autoload)) {
        require_once $autoload;
        return true;
    }

    bypf_log('Piero Fracasso Emails: Missing vendor/autoload.php. Run composer install.', 'error');

    add_action('admin_notices', function () {
        if (!current_user_can('manage_options')) {
            return;
        }
        echo '<div class="notice notice-error"><p>' . esc_html__(
            'Missing dependencies for Piero Fracasso Perfumes WooCommerce Emails plugin. Please run composer install.',
            'piero-fracasso-emails'
        ) . '</p></div>';
    });

    return false;
}

function bypf_is_jimsoft_active()
{
    include_once ABSPATH . 'wp-admin/includes/plugin.php';

    $active_plugins = array_merge(
        (array) get_option('active_plugins', array()),
        array_keys((array) get_site_option('active_sitewide_plugins', array()))
    );

    foreach ($active_plugins as $plugin) {
        if (strpos($plugin, 'jimsoft') !== false) {
            return true;
        }
    }

    return false;
}

function bypf_emails_activation()
{
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
    if (!is_plugin_active('woocommerce/woocommerce.php')) {
        add_option('bypf_emails_wc_missing', true);
        deactivate_plugins(plugin_basename(__FILE__));
    }
}

function bypf_emails_activation_notice()
{
    if (get_option('bypf_emails_wc_missing')) {
        echo '<div class="notice notice-error"><p>' . esc_html__(
            'WooCommerce must be active to use Piero Fracasso Perfumes WooCommerce Emails plugin.',
            'piero-fracasso-emails'
        ) . '</p></div>';
        delete_option('bypf_emails_wc_missing');
    }
}

register_activation_hook(__FILE__, 'bypf_emails_activation');
add_action('admin_notices', 'bypf_emails_activation_notice');

// Debug: Confirm plugin is active on admin page loads
function bypierofracasso_debug_plugin_active()
{
    bypf_log('Piero Fracasso Perfumes WooCommerce Emails plugin (v' . BYPF_EMAILS_VERSION . ') is active on admin page load.');
}

// Debug: Log order save at the WordPress level
function bypierofracasso_debug_save_post($post_id, $post, $update)
{
    if (!$update || !function_exists('wc_get_order')) {
        return;
    }

    bypf_log("Order $post_id updated via save_post_shop_order hook");
    $order = wc_get_order($post_id);
    if ($order) {
        $old_status = get_post_meta($post_id, '_status_before_update', true) ?: $order->get_status();
        $new_status = $order->get_status();
        bypf_log("Order $post_id - Old status (meta): $old_status, New status: $new_status");
        update_post_meta($post_id, '_status_before_update', $new_status);
    }
}

// Trigger emails using woocommerce_order_status_changed hook
function bypierofracasso_handle_custom_email_trigger($order_id, $old_status, $new_status, $order)
{
    if (!function_exists('WC')) {
        return;
    }

    bypf_log("Order $order_id status changed from $old_status to $new_status (via woocommerce_order_status_changed hook)");
    $mailer = WC()->mailer()->get_emails();

    // Remove 'wc-' prefix for comparison
    $new_status = str_replace('wc-', '', $new_status);

    if ($new_status === 'shipped' && !empty($mailer['WC_Email_Shipped_Order'])) {
        bypf_log("Triggering WC_Email_Shipped_Order for order $order_id");
        $mailer['WC_Email_Shipped_Order']->trigger($order_id);
        bypf_log("Send result for WC_Email_Shipped_Order for order $order_id: Attempted");
    } elseif ($new_status === 'ready-for-pickup' && !empty($mailer['WC_Email_Ready_For_Pickup'])) {
        bypf_log("Triggering WC_Email_Ready_For_Pickup for order $order_id");
        $mailer['WC_Email_Ready_For_Pickup']->trigger($order_id);
        bypf_log("Send result for WC_Email_Ready_For_Pickup for order $order_id: Attempted");
    } elseif ($new_status === 'pending-payment' && !empty($mailer['WC_Email_Pending_Order'])) {
        bypf_log("Triggering WC_Email_Pending_Order for order $order_id");
        $mailer['WC_Email_Pending_Order']->trigger($order_id);
        bypf_log("Send result for WC_Email_Pending_Order for order $order_id: Attempted");
    } elseif ($new_status === 'received' && !empty($mailer['WC_Email_Order_Received'])) {
        bypf_log("Triggering WC_Email_Order_Received for order $order_id");
        $mailer['WC_Email_Order_Received']->trigger($order_id);
        bypf_log("Send result for WC_Email_Order_Received for order $order_id: Attempted");
    }
}

// Debug: Log before order save
function bypierofracasso_debug_before_save($order, $data_store)
{
    bypf_log("woocommerce_before_order_object_save hook fired for order {$order->get_id()}");
    if ($order->get_id()) {
        $old_status = $order->get_status('edit');
        $new_status = isset($order->data['status']) ? $order->data['status'] : $old_status;
        bypf_log("Order {$order->get_id()} - Old status: $old_status, New status: $new_status");
        if ($old_status !== $new_status) {
            bypf_log("Order {$order->get_id()} status changing from $old_status to $new_status (before save)");
        } else {
            bypf_log("Order {$order->get_id()} - No status change detected (old: $old_status, new: $new_status)");
        }
    } else {
        bypf_log("Order object has no ID in woocommerce_before_order_object_save", 'warning');
    }
}

// Debug: Log after order save
function bypierofracasso_debug_after_save($order, $data_store)
{
    bypf_log("woocommerce_after_order_object_save hook fired for order {$order->get_id()}");
    $status = $order->get_status();
    bypf_log("Order {$order->get_id()} - Status after save: $status");
}

// Override WooCommerce email templates
function bypierofracasso_override_woocommerce_emails($template, $template_name, $template_path)
{
    $plugin_path = plugin_dir_path(__FILE__) . 'templates/emails/';
    $template_name = str_replace('emails/', '', $template_name);
    $custom_template = $plugin_path . $template_name;

    if (file_exists($custom_template)) {
        return $custom_template;
    }
    return $template;
}

// Load translations
function bypierofracasso_load_textdomain()
{
    load_plugin_textdomain('piero-fracasso-emails', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

// Add inline email styles
function bypierofracasso_add_email_styles($email)
{
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/emails/email-styles.php';
    $css = ob_get_clean();
    echo '<style type="text/css">' . wp_strip_all_tags($css) . '</style>';
}

// Register custom order statuses
function bypierofracasso_register_custom_statuses($statuses)
{
    $statuses['wc-received'] = array(
        'label' => _x('Received', 'Order status', 'piero-fracasso-emails'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Received <span class="count">(%s)</span>', 'Received <span class="count">(%s)</span>', 'piero-fracasso-emails'),
    );
    $statuses['wc-pending-payment'] = array(
        'label' => _x('Pending Payment', 'Order status', 'piero-fracasso-emails'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Pending Payment <span class="count">(%s)</span>', 'Pending Payment <span class="count">(%s)</span>', 'piero-fracasso-emails'),
    );
    $statuses['wc-shipped'] = array(
        'label' => _x('Shipped', 'Order status', 'piero-fracasso-emails'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>', 'piero-fracasso-emails'),
    );
    $statuses['wc-ready-for-pickup'] = array(
        'label' => _x('Ready for Pickup', 'Order status', 'piero-fracasso-emails'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Ready for Pickup <span class="count">(%s)</span>', 'Ready for Pickup <span class="count">(%s)</span>', 'piero-fracasso-emails'),
    );
    $statuses['wc-invoice'] = array(
        'label' => _x('Invoice', 'Order status', 'piero-fracasso-emails'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Invoice <span class="count">(%s)</span>', 'Invoice <span class="count">(%s)</span>', 'piero-fracasso-emails'),
    );
    return $statuses;
}

// Make custom statuses available in WooCommerce
function bypierofracasso_add_custom_order_statuses($order_statuses)
{
    $order_statuses['wc-received'] = _x('Received', 'Order status', 'piero-fracasso-emails');
    $order_statuses['wc-pending-payment'] = _x('Pending Payment', 'Order status', 'piero-fracasso-emails');
    $order_statuses['wc-shipped'] = _x('Shipped', 'Order status', 'piero-fracasso-emails');
    $order_statuses['wc-ready-for-pickup'] = _x('Ready for Pickup', 'Order status', 'piero-fracasso-emails');
    $order_statuses['wc-invoice'] = _x('Invoice', 'Order status', 'piero-fracasso-emails');
    return $order_statuses;
}

// Ensure Bulk Actions Recognize Custom Statuses
function bypierofracasso_add_bulk_order_statuses($actions)
{
    $actions['mark_wc-shipped'] = __('Change status to Shipped', 'piero-fracasso-emails');
    $actions['mark_wc-ready-for-pickup'] = __('Change status to Ready for Pickup', 'piero-fracasso-emails');
    $actions['mark_wc-invoice'] = __('Change status to Invoice', 'piero-fracasso-emails');
    return $actions;
}


// Set Invoice status for applicable payment methods
function bypierofracasso_maybe_set_invoice_status($order_id){
    $order = wc_get_order($order_id);
    if(!$order){
        return;
    }
    $invoice_methods = apply_filters('pfp_invoice_payment_methods', array('pfp_invoice','bacs'));
    if(in_array($order->get_payment_method(), $invoice_methods, true)){
        if($order->has_status('on-hold') || $order->has_status('pending')){
            $order->update_status('invoice');
        }
    }
}
// Set Initial Status to "Received" After Payment
//add_action('woocommerce_payment_complete', 'bypierofracasso_set_initial_received_status', 10, 1);
//function bypierofracasso_set_initial_received_status($order_id)
//{
//    $order = wc_get_order($order_id);
//    if ($order && !$order->has_status('received')) { // Remove 'wc-' prefix
//        bypf_log("Setting order $order_id to received after payment");
//        $order->update_status('wc-received', __('Order set to Received after payment.', 'piero-fracasso-emails')); // Keep 'wc-' for update_status
//        $email = WC()->mailer()->get_emails()['WC_Email_Order_Received'];
//        if ($email && $email->is_enabled()) {
//            $email->trigger($order_id);
//        }
//    }
//}

//// Set Initial Status to "Received" After Payment
//add_filter('woocommerce_payment_complete_order_status', 'bypierofracasso_order_status_after_payment', 10, 2);
//function bypierofracasso_order_status_after_payment($order_status, $order_id)
//{
//    $order = wc_get_order($order_id);
//    if ($order->has_status(array('pending', 'failed')) && !$order->has_status('received')) {
//        return 'wc-received';  // Set your custom order status
//    }
//    return $order_status;
//}

// Hook to modify the order status after payment completion
function bypierofracasso_order_status_after_payment($order_status, $order_id)
{
    $order = wc_get_order($order_id);

    // If the order is in "Pending" or "Failed" state, set it to a custom status
    if ($order->has_status(array('pending', 'failed')) && !$order->has_status('received')) {
//        $order->update_status('wc-received');  // Set custom status
        return 'wc-received';
    }

    return $order_status;
}

// Hook to ensure the custom email template is used for Processing Order emails
//add_filter('woocommerce_locate_template', 'bypierofracasso_woocommerce_email_template', 10, 3);
//function bypierofracasso_woocommerce_email_template($template, $template_name, $template_path)
//{
//    if ($template_name === 'emails/customer-processing-order.php') {
//        return plugin_dir_path(__FILE__) . 'templates/emails/customer-processing-order.php';
//    }
//    return $template;
//}

// Hook to send the Processing Order email when an order status changes to "Processing"
function send_bypierofracasso_processing_email($order_id, $order)
{
    $mailer = WC()->mailer();
    $mails = $mailer->get_emails();

    if (!empty($mails['WC_Email_Customer_Processing_Order'])) {
        $mails['WC_Email_Customer_Processing_Order']->trigger($order_id);
    }
}

// Hook to send the New Order email to the admin when an order is placed
function bypierofracasso_send_new_order_email_to_admin($order_id)
{
    $mailer = WC()->mailer();
    $mails = $mailer->get_emails();

    if (!empty($mails['WC_Email_New_Order'])) {
        $mails['WC_Email_New_Order']->trigger($order_id);
    }
}

// Manual Trigger for Debugging
function bypierofracasso_manual_email_trigger()
{
    if (isset($_GET['bypf_trigger_email']) && current_user_can('manage_woocommerce')) {
        $nonce = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';
        if (!wp_verify_nonce($nonce, 'bypf_trigger_email')) {
            return;
        }
        $order_id = intval($_GET['bypf_trigger_email']);
        $order = wc_get_order($order_id);
        if ($order) {
            $status = $order->get_status();
            // Remove 'wc-' prefix for comparison
            $status = str_replace('wc-', '', $status);
            bypf_log("Manual trigger attempt for order $order_id with status $status");
            $mailer = WC()->mailer()->get_emails();

            if ($status === 'shipped' && !empty($mailer['WC_Email_Shipped_Order'])) {
                bypf_log("Checking WC_Email_Shipped_Order: " . ($mailer['WC_Email_Shipped_Order'] ? 'Found' : 'Not found') . ", Enabled: " . ($mailer['WC_Email_Shipped_Order'] && $mailer['WC_Email_Shipped_Order']->is_enabled() ? 'Yes' : 'No'));
                if ($mailer['WC_Email_Shipped_Order'] && $mailer['WC_Email_Shipped_Order']->is_enabled()) {
                    bypf_log("Triggering WC_Email_Shipped_Order for order $order_id");
                    $mailer['WC_Email_Shipped_Order']->trigger($order_id);
                    bypf_log("Send result for WC_Email_Shipped_Order for order $order_id: Attempted");
                } else {
                    bypf_log("WC_Email_Shipped_Order not found or not enabled for manual trigger of order $order_id", 'warning');
                }
            } elseif ($status === 'ready-for-pickup' && !empty($mailer['WC_Email_Ready_For_Pickup'])) {
                bypf_log("Checking WC_Email_Ready_For_Pickup: " . ($mailer['WC_Email_Ready_For_Pickup'] ? 'Found' : 'Not found') . ", Enabled: " . ($mailer['WC_Email_Ready_For_Pickup'] && $mailer['WC_Email_Ready_For_Pickup']->is_enabled() ? 'Yes' : 'No'));
                if ($mailer['WC_Email_Ready_For_Pickup'] && $mailer['WC_Email_Ready_For_Pickup']->is_enabled()) {
                    bypf_log("Triggering WC_Email_Ready_For_Pickup for order $order_id");
                    $mailer['WC_Email_Ready_For_Pickup']->trigger($order_id);
                    bypf_log("Send result for WC_Email_Ready_For_Pickup for order $order_id: Attempted");
                } else {
                    bypf_log("WC_Email_Ready_For_Pickup not found or not enabled for manual trigger of order $order_id", 'warning');
                }
            } elseif ($status === 'pending-payment' && !empty($mailer['WC_Email_Pending_Order'])) {
                bypf_log("Checking WC_Email_Pending_Order: " . ($mailer['WC_Email_Pending_Order'] ? 'Found' : 'Not found') . ", Enabled: " . ($mailer['WC_Email_Pending_Order'] && $mailer['WC_Email_Pending_Order']->is_enabled() ? 'Yes' : 'No'));
                if ($mailer['WC_Email_Pending_Order'] && $mailer['WC_Email_Pending_Order']->is_enabled()) {
                    bypf_log("Triggering WC_Email_Pending_Order for order $order_id");
                    $mailer['WC_Email_Pending_Order']->trigger($order_id);
                    bypf_log("Send result for WC_Email_Pending_Order for order $order_id: Attempted");
                } else {
                    bypf_log("WC_Email_Pending_Order not found or not enabled for manual trigger of order $order_id", 'warning');
                }
            } elseif ($status === 'received' && !empty($mailer['WC_Email_Order_Received'])) {
                bypf_log("Checking WC_Email_Order_Received: " . ($mailer['WC_Email_Order_Received'] ? 'Found' : 'Not found') . ", Enabled: " . ($mailer['WC_Email_Order_Received'] && $mailer['WC_Email_Order_Received']->is_enabled() ? 'Yes' : 'No'));
                if ($mailer['WC_Email_Order_Received'] && $mailer['WC_Email_Order_Received']->is_enabled()) {
                    bypf_log("Triggering WC_Email_Order_Received for order $order_id");
                    $mailer['WC_Email_Order_Received']->trigger($order_id);
                    bypf_log("Send result for WC_Email_Order_Received for order $order_id: Attempted");
                } else {
                    bypf_log("WC_Email_Order_Received not found or not enabled for manual trigger of order $order_id", 'warning');
                }
            } else {
                bypf_log("Order $order_id has unsupported status $status for manual trigger", 'warning');
            }
        } else {
            bypf_log("Manual trigger failed: Order $order_id not found", 'error');
        }
    }
}

function bypierofracasso_woocommerce_emails_bootstrap()
{
    if (!did_action('woocommerce_loaded') && !class_exists('WooCommerce') && !function_exists('wc')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-warning"><p>' . esc_html__(
                'WooCommerce is required for Piero Fracasso Perfumes WooCommerce Emails plugin to work.',
                'piero-fracasso-emails'
            ) . '</p></div>';
        });
        return;
    }

    if (!bypf_emails_load_autoloader()) {
        return;
    }

    require_once plugin_dir_path(__FILE__) . 'includes/class-email-manager.php';
    require_once plugin_dir_path(__FILE__) . 'templates/emails/setting-wc-email.php';

    if (bypf_is_jimsoft_active()) {
        bypf_log('Piero Fracasso Emails: JimSoft extension detected; please deactivate it.', 'warning');
        add_action('admin_notices', function () {
            echo '<div class="notice notice-warning"><p>' . esc_html__(
                'JimSoft QR invoice plugin is active. Please deactivate it; functionality is now provided by Piero Fracasso Perfumes WooCommerce Emails.',
                'piero-fracasso-emails'
            ) . '</p></div>';
        });
    }

    require_once plugin_dir_path(__FILE__) . 'includes/class-pfp-gateway-invoice.php';
    add_filter('woocommerce_payment_gateways', 'bypierofracasso_register_invoice_gateway');

    if (class_exists('PFP_Email_Manager')) {
        new PFP_Email_Manager();
    }

    bypierofracasso_load_textdomain();
    add_action('woocommerce_email_header', 'bypierofracasso_add_email_styles', 20);
    add_filter('woocommerce_locate_template', 'bypierofracasso_override_woocommerce_emails', 10, 3);
    add_filter('woocommerce_register_shop_order_post_statuses', 'bypierofracasso_register_custom_statuses');
    add_filter('wc_order_statuses', 'bypierofracasso_add_custom_order_statuses');
    add_filter('bulk_actions-edit-shop_order', 'bypierofracasso_add_bulk_order_statuses');
    add_action('woocommerce_new_order', 'bypierofracasso_maybe_set_invoice_status', 20, 1);
    add_filter('woocommerce_payment_complete_order_status', 'bypierofracasso_order_status_after_payment', 10, 2);
    add_action('woocommerce_order_status_processing', 'send_bypierofracasso_processing_email', 10, 2);
    add_action('woocommerce_new_order', 'bypierofracasso_send_new_order_email_to_admin', 10, 1);
    add_action('woocommerce_order_status_changed', 'bypierofracasso_handle_custom_email_trigger', 9999, 4);

    if (defined('WP_DEBUG') && WP_DEBUG) {
        add_action('admin_init', 'bypierofracasso_debug_plugin_active');
        add_action('save_post_shop_order', 'bypierofracasso_debug_save_post', 10, 3);
        add_action('woocommerce_before_order_object_save', 'bypierofracasso_debug_before_save', 999, 2);
        add_action('woocommerce_after_order_object_save', 'bypierofracasso_debug_after_save', 999, 2);
        add_action('admin_init', 'bypierofracasso_manual_email_trigger');
    }
}

function bypierofracasso_register_invoice_gateway($gateways) {
    $gateways[] = 'PFP_Gateway_Invoice';
    return $gateways;
}

add_action('plugins_loaded', 'bypierofracasso_woocommerce_emails_bootstrap', 20);
