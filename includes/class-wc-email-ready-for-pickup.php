<?php
if (!defined('ABSPATH')) {
    exit;
}

class WC_Email_Ready_For_Pickup extends WC_Email
{

    public function __construct()
    {
        $this->id = 'wc_email_ready_for_pickup';
        $this->title = __('Ready for Pickup', 'bypierofracasso-woocommerce-emails');
        $this->description = __('Sent when an order is marked as Ready for Pickup.', 'bypierofracasso-woocommerce-emails');
        $this->template_html = 'customer-order-ready-for-pickup.php';
        $this->template_plain = 'plain/ready-for-pickup.php';
        $this->template_base = plugin_dir_path(__FILE__) . '../templates/emails/';
        $this->placeholders = array(
            '{order_date}' => '',
            '{order_number}' => '',
        );

        // Triggers for this email
//        add_action('woocommerce_order_status_wc-ready-for-pickup', array($this, 'trigger'), 10, 2);
        add_action('woocommerce_order_status_changed', array($this, 'bpf_handle_custom_email_trigger'), 9999, 4);

        // Call parent constructor
        parent::__construct();

        // Other settings
        $this->recipient = $this->get_option('recipient');
        if (!$this->recipient) {
            $this->recipient = get_option('admin_email');
        }
    }

    // When order status changed
    public function bpf_handle_custom_email_trigger($order_id, $old_status, $new_status, $order)
    {
        if ('ready-for-pickup' == $new_status) {
            $this->trigger($order_id, $order);
        }
    }
    public function trigger($order_id, $order = false)
    {
        if ($order_id && !$order) {
            $order = wc_get_order($order_id);
        }

        if (is_a($order, 'WC_Order')) {
            $this->object = $order;
            // Use customer's billing email as the default recipient
            $this->recipient = $this->object->get_billing_email();
            // Override with custom recipient from settings if set
            $custom_recipient = $this->get_option('recipient');
            if ($custom_recipient) {
                $this->recipient = $custom_recipient;
            }
            $this->placeholders['{order_date}'] = wc_format_datetime($this->object->get_date_created());
            $this->placeholders['{order_number}'] = $this->object->get_order_number();

            if ($this->is_enabled() && $this->get_recipient()) {
                error_log("Triggering email for order $order_id with status {$this->object->get_status()} to {$this->recipient}");
                $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
            } else {
                error_log("Email not sent for order $order_id: Either disabled or no recipient");
            }
        }
    }

    public function get_content_html()
    {
        return wc_get_template_html($this->template_html, array(
            'order' => $this->object,
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text' => false,
            'email' => $this,
        ), '', $this->template_base);
    }

    public function get_content_plain()
    {
        return wc_get_template_html($this->template_plain, array(
            'order' => $this->object,
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text' => true,
            'email' => $this,
        ), '', $this->template_base);
    }

    public function init_form_fields()
    {
        $this->form_fields = array(
            'enabled' => array(
                'title' => __('Enable/Disable', 'bypierofracasso-woocommerce-emails'),
                'type' => 'checkbox',
                'label' => __('Enable this email notification', 'bypierofracasso-woocommerce-emails'),
                'default' => 'yes',
            ),
            'recipient' => array(
                'title' => __('Recipient(s)', 'bypierofracasso-woocommerce-emails'),
                'type' => 'text',
                'description' => sprintf(__('Enter recipients (comma separated) for this email. Defaults to %s.', 'bypierofracasso-woocommerce-emails'), '<code>' . esc_attr(get_option('admin_email')) . '</code>'),
                'placeholder' => '',
                'default' => '',
            ),
            'subject' => array(
                'title' => __('Subject', 'bypierofracasso-woocommerce-emails'),
                'type' => 'text',
                'description' => sprintf(__('Defaults to %s', 'bypierofracasso-woocommerce-emails'), '<code>' . $this->get_default_subject() . '</code>'),
                'placeholder' => $this->get_default_subject(),
                'default' => '',
            ),
            'heading' => array(
                'title' => __('Email Heading', 'bypierofracasso-woocommerce-emails'),
                'type' => 'text',
                'description' => sprintf(__('Defaults to %s', 'bypierofracasso-woocommerce-emails'), '<code>' . $this->get_default_heading() . '</code>'),
                'placeholder' => $this->get_default_heading(),
                'default' => '',
            ),
            'email_type' => array(
                'title' => __('Email Type', 'bypierofracasso-woocommerce-emails'),
                'type' => 'select',
                'description' => __('Choose which format of email to send.', 'bypierofracasso-woocommerce-emails'),
                'default' => 'html',
                'class' => 'email_type',
                'options' => $this->get_email_type_options(),
                'desc_tip' => true,
            ),
        );
    }

    public function get_default_subject()
    {
        return __('Your order is ready for pickup #{order_number}', 'bypierofracasso-woocommerce-emails');
    }

    public function get_default_heading()
    {
        return __('Order Ready for Pickup', 'bypierofracasso-woocommerce-emails');
    }
}
