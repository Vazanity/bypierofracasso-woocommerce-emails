<?php
if (!defined('ABSPATH')) {
    exit;
}

class PFP_Email_Manager {
    public function __construct() {
        add_filter('woocommerce_email_classes', array($this, 'add_custom_emails'), 5);
        add_action('init', array($this, 'log_registered_email_states'), 20);
        add_action('init', array($this, 'configure_order_received_email'), 30);
        add_filter('woocommerce_email_enabled_customer_payment_retry', '__return_false');
        add_filter('woocommerce_email_enabled_customer_completed_renewal_order', '__return_false');
        add_filter('woocommerce_email_enabled_customer_completed_switch_order', '__return_false');
        add_filter('woocommerce_email_enabled_customer_renewal_invoice', '__return_false');
        add_filter('woocommerce_email_enabled_expired_subscription', '__return_false');
        add_filter('woocommerce_email_enabled_on_hold_subscription', '__return_false');
        // Disable any stray failed order emails
        add_filter('woocommerce_email_enabled_customer_failed_order', '__return_false');
        add_filter('woocommerce_email_enabled_failed_order', function($enabled, $email) {
            if (!$email instanceof WC_Email) {
                return false;
            }

            // Only enable if explicitly our override
            return $email->template_html === 'admin-failed-order.php' ? $enabled : false;
        }, 999, 2);

        add_filter('woocommerce_email_attachments', array($this, 'maybe_attach_invoice_pdf'), 10, 4);
        add_filter('woocommerce_order_actions', array($this, 'register_manual_order_actions'), 10, 2);
        add_action('woocommerce_order_action_pfp_send_payment_reminder', array($this, 'handle_manual_payment_reminder'));
    }

    public function add_custom_emails($email_classes) {
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-order-received.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-pending-order.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-shipped-order.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-ready-for-pickup.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-customer-payment-failed.php';
        require_once plugin_dir_path(__FILE__) . 'class-wc-email-customer-payment-reminder.php';

        $email_classes['PFP_Email_Order_Received'] = new PFP_Email_Order_Received();
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

    public function configure_order_received_email()
    {
        if (!function_exists('WC')) {
            return;
        }

        $mailer = WC()->mailer();

        if (!$mailer || !method_exists($mailer, 'get_emails')) {
            return;
        }

        $emails = $mailer->get_emails();
        $email  = is_array($emails) && isset($emails['PFP_Email_Order_Received']) ? $emails['PFP_Email_Order_Received'] : null;

        if (!$email || !$email instanceof WC_Email) {
            error_log('[PFP] Email Manager: Order_Received email not initialized yet; skipping.');
            return;
        }

        if (empty($email->template_base)) {
            $email->template_base = plugin_dir_path(__FILE__) . '../templates/';
        }

        if (empty($email->template_html)) {
            $email->template_html = 'emails/customer-order-received.php';
        }

        if (empty($email->template_plain)) {
            $email->template_plain = 'emails/customer-order-received.php';
        }
    }

    public function maybe_attach_invoice_pdf($attachments, $email_id, $order, $email)
    {
        if (!$order instanceof WC_Order) {
            return $attachments;
        }

        if ('pfp_invoice' !== $order->get_payment_method()) {
            return $attachments;
        }

        $is_order_received = ('pfp_email_order_received' === $email_id) || ($email instanceof PFP_Email_Order_Received);
        $is_reminder       = ('pfp_email_customer_payment_reminder' === $email_id) || ($email instanceof PFP_Email_Customer_Payment_Reminder);

        if (!$is_order_received && !$is_reminder) {
            return $attachments;
        }

        $pdf_path = pfp_get_invoice_pdf_path($order);

        if ($pdf_path && file_exists($pdf_path)) {
            $attachments[] = $pdf_path;
            error_log('[PFP] Attached PDF invoice for order ' . $order->get_id());
        } else {
            error_log('[PFP] Skipped PDF attachment for order ' . $order->get_id() . ' – file missing.');
        }

        return $attachments;
    }

    public function register_manual_order_actions($actions, $order)
    {
        if ($order instanceof WC_Order && 'pfp_invoice' === $order->get_payment_method()) {
            $actions['pfp_send_payment_reminder'] = __('Zahlungserinnerung senden', 'bypierofracasso-woocommerce-emails');
        }

        return $actions;
    }

    public function handle_manual_payment_reminder($order)
    {
        if (!$order instanceof WC_Order) {
            return;
        }

        if ('pfp_invoice' !== $order->get_payment_method()) {
            error_log('[PFP] Manual payment reminder skipped for non-invoice order ' . $order->get_id());
            return;
        }

        if (!function_exists('WC')) {
            error_log('[PFP] Manual payment reminder skipped – WooCommerce not loaded for order ' . $order->get_id());
            return;
        }

        $mailer = WC()->mailer();

        if (!$mailer || !isset($mailer->emails['PFP_Email_Customer_Payment_Reminder'])) {
            error_log('[PFP] Manual payment reminder skipped – email class missing for order ' . $order->get_id());
            return;
        }

        $reminder_email = $mailer->emails['PFP_Email_Customer_Payment_Reminder'];

        if (!$reminder_email instanceof WC_Email) {
            error_log('[PFP] Manual payment reminder skipped – email instance invalid for order ' . $order->get_id());
            return;
        }

        $reminder_email->trigger($order->get_id(), $order);
        error_log('[PFP] Manual payment reminder sent for order ' . $order->get_id());
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
