<?php
if (!defined('ABSPATH')) {
    exit;
}

class WC_Email_Order_Received extends WC_Email
{
    public function __construct()
    {
        $this->id = 'order_received';
        $this->title = __('Bestellung erhalten', 'woocommerce');
        $this->description = __('Diese E-Mail wird gesendet, wenn eine Bestellung aufgegeben wurde.', 'woocommerce');
        $this->heading = __('Vielen Dank für deine Bestellung!', 'woocommerce');
        $this->subject = __('Deine Bestellung bei byPieroFracasso wurde erhalten', 'woocommerce');

        $this->template_html = 'customer-order-received.php'; // Fixed path
        $this->template_plain = 'plain/customer-order-received.php'; // Fixed path

        $this->customer_email = true;

        add_action('woocommerce_order_status_changed', array($this, 'bpf_handle_custom_email_trigger'), 9999, 4);

        parent::__construct();
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

        $this->setup_locale();
        $this->recipient = $order->get_billing_email();
        $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
        $this->restore_locale();
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
