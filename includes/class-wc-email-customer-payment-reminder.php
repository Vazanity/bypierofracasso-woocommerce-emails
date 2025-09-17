<?php
if (!defined('ABSPATH')) {
    exit;
}

class PFP_Email_Customer_Payment_Reminder extends WC_Email
{
    public function __construct()
    {
        $this->id             = 'customer_payment_reminder';
        $this->title          = __('Zahlungserinnerung', 'bypierofracasso-woocommerce-emails');
        $this->description    = __('Manuell ausgelöste Zahlungserinnerung für Rechnungsbestellungen.', 'bypierofracasso-woocommerce-emails');
        $this->customer_email = true;
        $this->heading        = __('Zahlungserinnerung', 'bypierofracasso-woocommerce-emails');
        $this->subject        = __('Zahlungserinnerung zu Ihrer Bestellung {order_number}', 'bypierofracasso-woocommerce-emails');
        $this->template_html  = 'emails/customer-payment-reminder.php';
        $this->template_base  = plugin_dir_path(__FILE__) . '../templates/';

        add_action('pfp_send_payment_reminder_notification', array($this, 'trigger'), 10, 1);
        parent::__construct();
    }

    public function trigger($order_id)
    {
        if ($order_id) {
            $this->object    = wc_get_order($order_id);
            $this->recipient = $this->object ? $this->object->get_billing_email() : '';
        }

        if (!$this->is_enabled() || !$this->get_recipient() || !$this->object) {
            if (function_exists('pfp_log')) {
                pfp_log('[PFP] Skipped payment reminder send for order #' . absint($order_id) . ' (missing recipient or disabled)', 'notice');
            } else {
                bypf_log('[PFP] Skipped payment reminder send for order #' . absint($order_id) . ' (missing recipient or disabled)', 'notice');
            }
            return;
        }

        $this->setup_locale();

        if (function_exists('pfp_log')) {
            pfp_log('[PFP] Sending payment reminder for order #' . $this->object->get_id());
        } else {
            bypf_log('[PFP] Sending payment reminder for order #' . $this->object->get_id());
        }

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
