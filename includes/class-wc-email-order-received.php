<?php
if (!defined('ABSPATH')) {
    exit;
}

class PFP_Email_Order_Received extends WC_Email
{
    public $heading_default = '';

    public function __construct()
    {
        $this->id              = 'pfp_email_order_received';
        $this->title           = __('Bestellung erhalten', 'bypierofracasso-woocommerce-emails');
        $this->description     = __('Bestellbestätigung für Kunden, inklusive Rechnungshinweisen bei Rechnungskauf.', 'bypierofracasso-woocommerce-emails');
        $this->heading_default = __('Bestellung erhalten', 'bypierofracasso-woocommerce-emails');
        $this->heading         = $this->heading_default;
        $this->subject         = __('Deine Bestellung bei Piero Fracasso Perfumes wurde erhalten', 'bypierofracasso-woocommerce-emails');
        $this->customer_email  = true;
        $this->template_html   = 'emails/customer-order-received.php';
        $this->template_plain  = 'emails/customer-order-received.php';
        $this->template_base   = plugin_dir_path(__FILE__) . '../templates/';

        parent::__construct();

        add_action('woocommerce_checkout_order_processed', array($this, 'trigger_from_checkout'), 20, 1);
        add_action('woocommerce_order_status_pending_to_invoice', array($this, 'trigger_from_status'), 10, 2);
        add_action('woocommerce_order_status_on-hold_to_invoice', array($this, 'trigger_from_status'), 10, 2);
    }

    public function get_title()
    {
        return apply_filters('woocommerce_email_title_' . $this->id, $this->title, $this);
    }

    public function get_description()
    {
        return $this->description;
    }

    public function get_heading()
    {
        $heading = $this->format_string($this->heading);

        return apply_filters('woocommerce_email_heading_' . $this->id, $heading, $this->object, $this);
    }

    public function get_subject()
    {
        $subject = $this->format_string($this->subject);

        return apply_filters('woocommerce_email_subject_' . $this->id, $subject, $this->object, $this);
    }

    public function get_default_subject()
    {
        return __('Deine Bestellung bei Piero Fracasso Perfumes wurde erhalten', 'bypierofracasso-woocommerce-emails');
    }

    public function get_default_heading()
    {
        return $this->heading_default;
    }

    public function trigger_from_checkout($order_id)
    {
        error_log('[PFP] Order_Received: checkout trigger hit for order ' . absint($order_id));

        $order = wc_get_order($order_id);

        if (!$order instanceof WC_Order) {
            error_log('[PFP] Order_Received: checkout trigger skipped – order missing for ID ' . absint($order_id));
            return;
        }

        if ('pfp_invoice' !== $order->get_payment_method()) {
            error_log('[PFP] Order_Received: checkout trigger skipped – payment method ' . $order->get_payment_method());
            return;
        }

        $this->trigger($order_id, $order);
    }

    public function trigger_from_status($order_id, $order)
    {
        $status = ($order instanceof WC_Order) ? $order->get_status() : 'unknown';
        error_log('[PFP] Order_Received: status trigger hit ' . $status . ' for order ' . absint($order_id));

        if (!$order instanceof WC_Order) {
            $order = wc_get_order($order_id);
        }

        if (!$order instanceof WC_Order) {
            error_log('[PFP] Order_Received: status trigger skipped – order missing for ID ' . absint($order_id));
            return;
        }

        if ('pfp_invoice' !== $order->get_payment_method()) {
            error_log('[PFP] Order_Received: status trigger skipped – payment method ' . $order->get_payment_method());
            return;
        }

        $this->trigger($order_id, $order);
    }

    public function trigger($order_id, $order = false)
    {
        if (!$order_id) {
            $this->log('[PFP] Missing order id for pfp_email_order_received trigger', 'warning');
            return;
        }

        if (!$order instanceof WC_Order) {
            $order = wc_get_order($order_id);
        }

        if (!$order instanceof WC_Order) {
            $this->log('[PFP] Unable to locate order for pfp_email_order_received trigger (order #' . absint($order_id) . ')', 'error');
            return;
        }

        $this->object = $order;

        if ('pfp_invoice' === $order->get_payment_method()) {
            $this->heading = __('Bestellung erhalten – Zahlung per Rechnung', 'bypierofracasso-woocommerce-emails');
        } else {
            $this->heading = $this->heading_default;
        }

        $this->recipient = $order->get_billing_email();

        if (!$this->is_enabled()) {
            $this->log('[PFP] pfp_email_order_received disabled – skipping order #' . $order->get_id(), 'notice');
            return;
        }

        if (!$this->get_recipient()) {
            $this->log('[PFP] No recipient for pfp_email_order_received on order #' . $order->get_id(), 'warning');
            return;
        }

        $this->setup_locale();

        $this->log('[PFP] Sending pfp_email_order_received to ' . $this->get_recipient() . ' for order #' . $order->get_id());

        $sent = $this->send(
            $this->get_recipient(),
            $this->get_subject(),
            $this->get_content(),
            $this->get_headers(),
            $this->get_attachments()
        );

        $this->restore_locale();

        if ($sent) {
            $this->log('[PFP] pfp_email_order_received dispatched successfully for order #' . $order->get_id());
        } else {
            $this->log('[PFP] Failed sending pfp_email_order_received for order #' . $order->get_id(), 'error');
        }
    }

    public function get_content_html()
    {
        ob_start();
        wc_get_template(
            $this->template_html,
            array(
                'order'         => $this->object,
                'email_heading' => $this->get_heading(),
                'sent_to_admin' => false,
                'plain_text'    => false,
                'email'         => $this,
            ),
            '',
            $this->template_base
        );
        return ob_get_clean();
    }

    public function get_content_plain()
    {
        ob_start();
        wc_get_template(
            $this->template_html,
            array(
                'order'         => $this->object,
                'email_heading'  => $this->get_heading(),
                'sent_to_admin' => false,
                'plain_text'    => true,
                'email'         => $this,
            ),
            '',
            $this->template_base
        );
        $html = ob_get_clean();

        return wp_strip_all_tags($html);
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
