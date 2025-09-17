<?php
if (!defined('ABSPATH')) {
    exit;
}

class WC_Email_Order_Received extends WC_Email
{
    public function __construct()
    {
        $this->id             = 'customer_order_received';
        $this->title          = __('Bestellung erhalten', 'bypierofracasso-woocommerce-emails');
        $this->description    = __('Diese E-Mail wird gesendet, wenn eine Bestellung aufgegeben wurde.', 'bypierofracasso-woocommerce-emails');
        $this->heading        = __('Vielen Dank für deine Bestellung!', 'bypierofracasso-woocommerce-emails');
        $this->subject        = __('Deine Bestellung bei Piero Fracasso Perfumes wurde erhalten', 'bypierofracasso-woocommerce-emails');
        $this->customer_email = true;
        $this->enabled        = 'yes';
        $this->template_html  = 'emails/customer-order-received.php';
        $this->template_plain = 'emails/customer-order-received.php';
        $this->template_base  = plugin_dir_path(__FILE__) . '../templates/';

        parent::__construct();
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
        return __('Vielen Dank für deine Bestellung!', 'bypierofracasso-woocommerce-emails');
    }

    public function trigger($order_id, $order = null)
    {
        if (!$order_id) {
            $this->log('[PFP] Missing order id for customer_order_received trigger', 'warning');
            return;
        }

        if (!$order instanceof WC_Order) {
            $order = wc_get_order($order_id);
        }

        if (!$order instanceof WC_Order) {
            $this->log('[PFP] Unable to locate order for customer_order_received trigger (order #' . absint($order_id) . ')', 'error');
            return;
        }

        $this->object    = $order;
        $this->recipient = $order->get_billing_email();

        if (!$this->is_enabled()) {
            $this->log('[PFP] customer_order_received email disabled – skipping order #' . $order->get_id(), 'notice');
            return;
        }

        if (!$this->get_recipient()) {
            $this->log('[PFP] No recipient for customer_order_received on order #' . $order->get_id(), 'warning');
            return;
        }

        $this->setup_locale();

        $this->log('[PFP] Sending customer_order_received to ' . $this->get_recipient() . ' for order #' . $order->get_id());

        $sent = $this->send(
            $this->get_recipient(),
            $this->get_subject(),
            $this->get_content(),
            $this->get_headers(),
            $this->get_attachments()
        );

        $this->restore_locale();

        if ($sent) {
            $this->log('[PFP] customer_order_received dispatched successfully for order #' . $order->get_id());
        } else {
            $this->log('[PFP] Failed sending customer_order_received for order #' . $order->get_id(), 'error');
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
