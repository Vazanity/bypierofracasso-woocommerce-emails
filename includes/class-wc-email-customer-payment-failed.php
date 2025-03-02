<?php
if (!defined('ABSPATH')) {
    exit;
}

class WC_Email_Customer_Payment_Failed extends WC_Email {
    public function __construct() {
        $this->id = 'customer_payment_failed';
        $this->customer_email = true;
        $this->title = __('Customer Payment Failed', 'bypierofracasso-woocommerce-emails');
        $this->description = __('Sent to customers when payment fails for an order.', 'bypierofracasso-woocommerce-emails');
        $this->template_base = plugin_dir_path(__FILE__) . '../templates/emails/';
        $this->template_html = 'customer-payment-failed.php';
        $this->placeholders = array(
            '{order_number}' => '',
            '{order_date}'   => '',
        );

        parent::__construct();
    }

    public function trigger($order_id, $order = false) {
        if ($order_id && !$order) {
            $order = wc_get_order($order_id);
        }

        // Fallback for preview if no order
        if (!$order) {
            $orders = wc_get_orders(array('limit' => 1, 'status' => 'completed')); // Use a completed order for preview
            $order = !empty($orders) ? $orders[0] : null;
        }

        if ($order instanceof WC_Order) {
            $this->object = $order;
            $this->recipient = $this->object->get_billing_email();
            $this->placeholders['{order_number}'] = $this->object->get_order_number();
            $this->placeholders['{order_date}'] = wc_format_datetime($this->object->get_date_created());
        } else {
            // Minimal fallback for blank preview
            $this->recipient = 'preview@example.com';
            $this->placeholders['{order_number}'] = 'N/A';
            $this->placeholders['{order_date}'] = date('Y-m-d');
        }

        if ($this->is_enabled() && $this->get_recipient()) {
            $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
        }
    }

    public function get_default_subject() {
        return __('Payment Failed for Order #{order_number}', 'bypierofracasso-woocommerce-emails');
    }

    public function get_default_heading() {
        return __('Payment Failed', 'bypierofracasso-woocommerce-emails');
    }

    public function get_content_html() {
        return wc_get_template_html(
            $this->template_html,
            array(
                'order'              => $this->object,
                'email_heading'      => $this->get_heading(),
                'additional_content' => $this->get_additional_content(),
                'sent_to_admin'      => false,
                'plain_text'         => false,
                'email'              => $this,
            ),
            '',
            $this->template_base
        );
    }
}
