<?php
if (!defined('ABSPATH')) {
    exit;
}

class WC_Email_Shipped_Order extends WC_Email {
    public function __construct() {
        $this->id             = 'shipped_order';
        $this->title          = __('Bestellung versendet', 'woocommerce');
        $this->description    = __('Diese E-Mail wird gesendet, wenn eine Bestellung als „Versendet“ markiert wird.', 'woocommerce');
        $this->heading        = __('Deine Bestellung ist auf dem Weg!', 'woocommerce');
        $this->subject        = __('Deine Bestellung wurde versendet', 'woocommerce');

        $this->template_html  = 'emails/customer-order-shipped.php';
        $this->template_plain = 'emails/plain/customer-order-shipped.php';
        
        $this->customer_email = true;

        add_action('woocommerce_order_status_wc-shipped_notification', array($this, 'trigger'), 10, 2);

        parent::__construct();
    }

    public function trigger($order_id, $order = false) {
        if (!$order_id) {
            return;
        }

        if (!$order) {
            $order = wc_get_order($order_id);
        }

        $this->setup_locale();
        $this->recipient = $order->get_billing_email();
        $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
        $this->restore_locale();
    }

    public function get_content_html() {
        ob_start();
        wc_get_template($this->template_html, array(
            'order'         => $this->object,
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text'    => false,
            'email'         => $this,
        ));
        return ob_get_clean();
    }

    public function get_content_plain() {
        ob_start();
        wc_get_template($this->template_plain, array(
            'order'         => $this->object,
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text'    => true,
            'email'         => $this,
        ));
        return ob_get_clean();
    }
}
