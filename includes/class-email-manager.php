<?php
if (!defined('ABSPATH')) {
    exit;
}

class PFP_Email_Manager {
    public function __construct() {
        add_filter('woocommerce_email_classes', array($this, 'add_custom_emails'), 5);
        add_action('init', array($this, 'log_registered_email_states'), 20);
        add_filter('woocommerce_email_enabled_customer_payment_retry', '__return_false');
        add_filter('woocommerce_email_enabled_customer_completed_renewal_order', '__return_false');
        add_filter('woocommerce_email_enabled_customer_completed_switch_order', '__return_false');
        add_filter('woocommerce_email_enabled_customer_renewal_invoice', '__return_false');
        add_filter('woocommerce_email_enabled_expired_subscription', '__return_false');
        add_filter('woocommerce_email_enabled_on_hold_subscription', '__return_false');
        // Disable any stray failed order emails
        add_filter('woocommerce_email_enabled_customer_failed_order', '__return_false');
        add_filter('woocommerce_email_enabled_failed_order', function($enabled, $email) {
            // Only enable if explicitly our override
            return $email->template_html === 'admin-failed-order.php' ? $enabled : false;
        }, 999, 2);
    }

    public function add_custom_emails($email_classes) {
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-order-received.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-pending-order.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-shipped-order.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-ready-for-pickup.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-customer-payment-failed.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-customer-payment-reminder.php';

        $email_classes['PFP_Email_Order_Received'] = new WC_Email_Order_Received();
        $email_classes['pending_order'] = new WC_Email_Pending_Order();
        $email_classes['wc_email_shipped_order'] = new WC_Email_Shipped_Order();
        $email_classes['wc_email_ready_for_pickup'] = new WC_Email_Ready_For_Pickup();
        $email_classes['customer_payment_failed'] = new WC_Email_Customer_Payment_Failed();
        $email_classes['PFP_Email_Customer_Payment_Reminder'] = new PFP_Email_Customer_Payment_Reminder();

        // Debug: Log the registered email classes
        $this->log_registration_once($email_classes);

        if (isset($email_classes['WC_Email_Customer_New_Account'])) {
            $email_classes['WC_Email_Customer_New_Account']->template_base = plugin_dir_path(__FILE__) . '../templates/emails/';
            $email_classes['WC_Email_Customer_New_Account']->template_html = 'customer-new-account.php';
        }

        if (isset($email_classes['WC_Email_Customer_Note'])) {
            $email_classes['WC_Email_Customer_Note']->template_base = plugin_dir_path(__FILE__) . '../templates/emails/';
            $email_classes['WC_Email_Customer_Note']->template_html = 'customer-note.php';
        }

        if (isset($email_classes['WC_Email_Customer_On_Hold_Order'])) {
            $email_classes['WC_Email_Customer_On_Hold_Order']->template_base = plugin_dir_path(__FILE__) . '../templates/emails/';
            $email_classes['WC_Email_Customer_On_Hold_Order']->template_html = 'customer-on-hold-order.php';
        }

        if (isset($email_classes['WC_Email_Customer_Processing_Order'])) {
            $email_classes['WC_Email_Customer_Processing_Order']->template_base = plugin_dir_path(__FILE__) . '../templates/emails/';
            $email_classes['WC_Email_Customer_Processing_Order']->template_html = 'customer-processing-order.php';
        }

        if (isset($email_classes['WC_Email_Customer_Refunded_Order'])) {
            $email_classes['WC_Email_Customer_Refunded_Order']->template_base = plugin_dir_path(__FILE__) . '../templates/emails/';
            $email_classes['WC_Email_Customer_Refunded_Order']->template_html = 'customer-refunded-order.php';
        }

        if (isset($email_classes['WC_Email_Customer_Reset_Password'])) {
            $email_classes['WC_Email_Customer_Reset_Password']->template_base = plugin_dir_path(__FILE__) . '../templates/emails/';
            $email_classes['WC_Email_Customer_Reset_Password']->template_html = 'customer-reset-password.php';
        }

        if (isset($email_classes['WC_Email_Failed_Order'])) {
            $email_classes['WC_Email_Failed_Order']->template_base = plugin_dir_path(__FILE__) . '../templates/emails/';
            $email_classes['WC_Email_Failed_Order']->template_html = 'admin-failed-order.php';
            $email_classes['WC_Email_Failed_Order']->title = __('Admin Failed Order', 'bypierofracasso-woocommerce-emails');
        }

        return $email_classes;
    }

    public function log_registered_email_states()
    {
        static $logged = false;

        if ($logged || !function_exists('WC')) {
            return;
        }

        $mailer = WC()->mailer();

        if (!$mailer || !method_exists($mailer, 'get_emails')) {
            return;
        }

        $emails = $mailer->get_emails();

        if (!is_array($emails) || empty($emails)) {
            return;
        }

        $logged = true;

        $states = array();

        foreach ($emails as $email) {
            $id       = isset($email->id) ? $email->id : get_class($email);
            $enabled  = method_exists($email, 'is_enabled') && $email->is_enabled() ? 'enabled' : 'disabled';
            $states[] = $id . ' (' . $enabled . ')';
        }

        $this->log('[PFP] Registered emails on init: ' . implode(', ', $states));
    }

    protected function log_registration_once($email_classes)
    {
        static $logged = false;

        if ($logged) {
            return;
        }

        $logged = true;

        $this->log('[PFP] Email classes registered: ' . implode(', ', array_keys($email_classes)));
    }

    protected function log($message, $level = 'info')
    {
        if (function_exists('pfp_log')) {
            pfp_log($message, $level);
            return;
        }

        bypf_log($message, $level);
    }
}
