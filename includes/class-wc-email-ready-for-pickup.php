<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WC_Email_Ready_For_Pickup extends WC_Email {
    public function __construct() {
        $this->id = 'customer_order_ready_for_pickup';
        $this->customer_email = true;
        $this->title = __('Order Ready for Pickup', 'bypierofracasso-woocommerce-emails');
        $this->description = __('Sent to customers when their order is ready for pickup.', 'bypierofracasso-woocommerce-emails');
        $this->template_base = plugin_dir_path(__FILE__) . '../templates/emails/';
        $this->template_html = 'customer-order-ready-for-pickup.php';
        $this->placeholders = array(
            '{order_number}' => '',
            '{order_date}'   => '',
        );

        // Call parent constructor
        parent::__construct();
    }

    public function trigger($order_id, $order = false) {
        if ($order_id && !$order) {
            $order = wc_get_order($order_id);
        }

        if ($order instanceof WC_Order) {
            $this->object = $order;
            $this->recipient = $this->object->get_billing_email();
            $this->placeholders['{order_number}'] = $this->object->get_order_number();
            $this->placeholders['{order_date}'] = wc_format_datetime($this->object->get_date_created());
        }

        if ($this->is_enabled() && $this->get_recipient()) {
            $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
        }
    }

    public function get_default_subject() {
        return __('Your Order #{order_number} is Ready for Pickup', 'bypierofracasso-woocommerce-emails');
    }

    public function get_default_heading() {
        return __('Order Ready for Pickup', 'bypierofracasso-woocommerce-emails');
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
