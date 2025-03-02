<?php
if (!defined('ABSPATH')) {
    exit;
}

class byPieroFracasso_Email_Manager {

    public function __construct() {
        // Eigene WooCommerce-E-Mails hinzufügen
        add_filter('woocommerce_email_classes', array($this, 'add_custom_emails'));

        // Standard-E-Mails deaktivieren, die nicht benötigt werden
        add_filter('woocommerce_email_enabled_customer_payment_retry', '__return_false');
        add_filter('woocommerce_email_enabled_customer_completed_renewal_order', '__return_false');
        add_filter('woocommerce_email_enabled_customer_completed_switch_order', '__return_false');
        add_filter('woocommerce_email_enabled_customer_renewal_invoice', '__return_false');
        add_filter('woocommerce_email_enabled_expired_subscription', '__return_false');
        add_filter('woocommerce_email_enabled_on_hold_subscription', '__return_false');
    }

    // Eigene E-Mails registrieren
    public function add_custom_emails($email_classes) {
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-shipped-order.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-pending-order.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-order-received.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-processing-order.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-ready-for-pickup.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-refunded-order.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-invoice.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-note.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-reset-password.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-admin-cancelled.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-admin-failed.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-admin-new.php';

        $email_classes['WC_Email_Shipped_Order'] = new WC_Email_Shipped_Order();
        $email_classes['WC_Email_Pending_Order'] = new WC_Email_Pending_Order();
        $email_classes['WC_Email_Order_Received'] = new WC_Email_Order_Received();
        $email_classes['WC_Email_Processing_Order'] = new WC_Email_Processing_Order();
        $email_classes['WC_Email_Ready_For_Pickup'] = new WC_Email_Ready_For_Pickup();
        $email_classes['WC_Email_Refunded_Order'] = new WC_Email_Refunded_Order();
        $email_classes['WC_Email_Invoice'] = new WC_Email_Invoice();
        $email_classes['WC_Email_Note'] = new WC_Email_Note();
        $email_classes['WC_Email_Reset_Password'] = new WC_Email_Reset_Password();
        $email_classes['WC_Email_Admin_Cancelled'] = new WC_Email_Admin_Cancelled();
        $email_classes['WC_Email_Admin_Failed'] = new WC_Email_Admin_Failed();
        $email_classes['WC_Email_Admin_New'] = new WC_Email_Admin_New();

        return $email_classes;
    }
}
