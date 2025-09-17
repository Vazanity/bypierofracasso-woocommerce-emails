<?php
if (!defined('ABSPATH')) {
    exit;
}

class PFP_Email_Customer_Payment_Reminder extends WC_Email
{
    public function __construct()
    {
        $this->id             = 'pfp_email_customer_payment_reminder';
        $this->title          = __('Zahlungserinnerung', 'bypierofracasso-woocommerce-emails');
        $this->description    = __('Wird manuell aus einer Bestellung gesendet, wenn die Rechnung überfällig ist. Fügt Rechnung als PDF bei.', 'bypierofracasso-woocommerce-emails');
        $this->customer_email = true;
        $this->heading        = __('Zahlungserinnerung', 'bypierofracasso-woocommerce-emails');
        $this->subject        = __('Zahlungserinnerung zu Ihrer Bestellung {order_number}', 'bypierofracasso-woocommerce-emails');
        $this->template_html  = 'emails/customer-payment-reminder.php';
        $this->template_base  = plugin_dir_path(__FILE__) . '../templates/';

        parent::__construct();
    }

    public function trigger($order_id, $order = false)
    {
        if (!$order instanceof WC_Order && $order_id) {
            $order = wc_get_order($order_id);
        }

        if (!$order instanceof WC_Order) {
            error_log('[PFP] Payment Reminder: missing order context for trigger ' . absint($order_id));
            return;
        }

        if ('pfp_invoice' !== $order->get_payment_method()) {
            error_log('[PFP] Payment Reminder: skipped for non-invoice order ' . $order->get_id());
            return;
        }

        $this->object    = $order;
        $this->recipient = $order->get_billing_email();

        if (!$this->is_enabled() || !$this->get_recipient()) {
            error_log('[PFP] Payment Reminder: not sent – disabled or missing recipient for order ' . $order->get_id());
            return;
        }

        $this->setup_locale();

        error_log('[PFP] Payment Reminder: sending email for order ' . $order->get_id() . ' to ' . $this->get_recipient());

        $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
        $this->restore_locale();
    }

    public function get_content_html()
    {
        return wc_get_template_html(
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
    }
}
