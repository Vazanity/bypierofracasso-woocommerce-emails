<?php
if (!defined('ABSPATH')) {
    exit;
}

class WC_Email_Order_Received extends WC_Email
{
    public function __construct()
    {
        $this->id = 'customer_order_received';
        $this->title = __('Bestellung erhalten', 'bypierofracasso-woocommerce-emails');
        $this->description = __('Diese E-Mail wird gesendet, wenn eine Bestellung aufgegeben wurde.', 'bypierofracasso-woocommerce-emails');
        $this->heading = __('Vielen Dank für deine Bestellung!', 'bypierofracasso-woocommerce-emails');
        $this->subject = __('Deine Bestellung bei Piero Fracasso Perfumes wurde erhalten', 'bypierofracasso-woocommerce-emails');

        $this->template_html = 'customer-order-received.php'; // Fixed path
        $this->template_plain = 'plain/customer-order-received.php'; // Fixed path

        $this->customer_email = true;

        add_action('woocommerce_order_status_changed', array($this, 'bpf_handle_custom_email_trigger'), 9999, 4);

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

    // When order status changed
    public function bpf_handle_custom_email_trigger($order_id, $old_status, $new_status, $order)
    {
        if ('received' == $new_status) { // Fixed status check
            $this->trigger($order_id, $order);
        }
    }

    public function trigger($order_id, $order = false)
    {
        if (!$order_id) {
            return;
        }

        if (!$order) {
            $order = wc_get_order($order_id);
        }

        if (is_a($order, 'WC_Order')) {
            $this->object = $order; // ← Important fix to correctly assign the order object
            $this->recipient = $order->get_billing_email();

            if ($order->get_meta('_pfp_customer_received_sent', true)) {
                if (function_exists('pfp_log')) {
                    pfp_log('[PFP] Skipping customer-order-received email; already sent for order #' . $order->get_id());
                } else {
                    bypf_log('[PFP] Skipping customer-order-received email; already sent for order #' . $order->get_id());
                }
                return;
            }

            $this->setup_locale();

            if ($this->is_enabled() && $this->get_recipient()) {
                if (function_exists('pfp_log')) {
                    pfp_log('[PFP] Triggering customer-order-received email send for order #' . $order->get_id());
                } else {
                    bypf_log('[PFP] Triggering customer-order-received email send for order #' . $order->get_id());
                }
                $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
                $order->update_meta_data('_pfp_customer_received_sent', current_time('mysql'));
                $order->save();
            }
            $this->restore_locale();
        }
    }


    public function get_content_html()
    {
        ob_start();
        wc_get_template($this->template_html, array(
            'order' => $this->object,
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text' => false,
            'email' => $this,
        ));
        return ob_get_clean();
    }

    public function get_content_plain()
    {
        ob_start();
        wc_get_template($this->template_plain, array(
            'order' => $this->object,
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text' => true,
            'email' => $this,
        ));
        return ob_get_clean();
    }
}
