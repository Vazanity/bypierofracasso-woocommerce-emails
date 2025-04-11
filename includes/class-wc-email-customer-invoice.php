<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WC_Email_Customer_Invoice extends WC_Email {
    public function __construct() {
        $this->id = 'customer_invoice';
        $this->customer_email = true;
        $this->title = __('Customer Invoice', 'woocommerce');
        $this->description = __('Sent to customers with invoice details.', 'woocommerce');
        $this->template_base = plugin_dir_path(__FILE__) . '../templates/emails/';
        $this->template_html = 'customer-invoice.php';
        $this->template_plain = 'plain/customer-invoice.php'; // Added
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
        return __('Your Invoice from byPieroFracasso #{order_number}', 'woocommerce');
    }

    public function get_default_heading() {
        return __('Invoice for Order #{order_number}', 'woocommerce');
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

    // Add plain text content method
    public function get_content_plain() {
        return wc_get_template_html(
            $this->template_plain,
            array(
                'order'              => $this->object,
                'email_heading'      => $this->get_heading(),
                'additional_content' => $this->get_additional_content(),
                'sent_to_admin'      => false,
                'plain_text'         => true,
                'email'              => $this,
            ),
            '',
            $this->template_base
        );
    }
}
