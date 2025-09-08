<?php
if (!defined('ABSPATH')) {
    exit;
}

class WC_Email_Pending_Order extends WC_Email
{
    public function __construct()
    {
        $this->id = 'pending_order';
        $this->title = __('Payment pending', 'piero-fracasso-emails');
        $this->description = __('This email is sent when an order is marked as “payment pending”.', 'piero-fracasso-emails');
        $this->heading = __('Please transfer the amount by QR bank payment', 'piero-fracasso-emails');
        $this->subject = __('Your order with Piero Fracasso Perfumes - Payment pending', 'piero-fracasso-emails');

        $this->template_html = 'customer-pending-order.php'; // Fixed path
        $this->template_plain = 'plain/customer-pending-order.php'; // Fixed path

        $this->customer_email = true;

        add_action('woocommerce_order_status_changed', array($this, 'bpf_handle_custom_email_trigger'), 9999, 4);

        parent::__construct();
    }

    // When order status changed
    public function bpf_handle_custom_email_trigger($order_id, $old_status, $new_status, $order)
    {
        if ('pending-payment' == $new_status) { // Fixed status check
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
