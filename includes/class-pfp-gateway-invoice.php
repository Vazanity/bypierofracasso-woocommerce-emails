<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Piero Fracasso Perfumes Invoice Payment Gateway.
 */
class PFP_Gateway_Invoice extends WC_Payment_Gateway
{
    /**
     * Reasons why the gateway is unavailable.
     *
     * @var array
     */
    protected $unavailability_reasons = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->id                 = 'pfp_invoice';
        $this->method_title       = __('Rechnung (Swiss QR)', 'piero-fracasso-emails');
        $this->method_description = __('Allows paying by Swiss QR invoice.', 'piero-fracasso-emails');
        $this->title              = __('Rechnung (Swiss QR)', 'piero-fracasso-emails');
        $this->has_fields = false;
        $this->supports   = array('products', 'refunds');

        $this->init_form_fields();
        $this->init_settings();

        $this->title       = $this->get_option('title', $this->title);
        $this->description = $this->get_option('description');

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        add_action('woocommerce_review_order_after_payment', array($this, 'maybe_render_checkout_diagnostics'));
    }

    /**
     * Initialize form fields.
     */
    public function init_form_fields()
    {
        $this->form_fields = array(
            'enabled' => array(
                'title'   => __('Enable/Disable', 'piero-fracasso-emails'),
                'type'    => 'checkbox',
                'label'   => __('Enable Swiss QR invoice payments', 'piero-fracasso-emails'),
                'default' => 'no',
            ),
            'title' => array(
                'title'       => __('Title', 'piero-fracasso-emails'),
                'type'        => 'text',
                'description' => __('Displayed on the checkout page.', 'piero-fracasso-emails'),
                'default'     => __('Rechnung (Swiss QR)', 'piero-fracasso-emails'),
                'desc_tip'    => true,
            ),
            'description' => array(
                'title'       => __('Description', 'piero-fracasso-emails'),
                'type'        => 'textarea',
                'description' => __('Checkout description shown to the customer.', 'piero-fracasso-emails'),
                'default'     => __('Sie erhalten eine Rechnung mit Swiss-QR-Code im Anhang der Bestellbestätigung.', 'piero-fracasso-emails'),
            ),
            'icon_url' => array(
                'title'       => __('Icon-URL (optional)', 'piero-fracasso-emails'),
                'type'        => 'url',
                'description' => __('Sie können ein Icon aus der Medienbibliothek verwenden (URL einfügen). Wenn leer, wird ein neutrales Inline-SVG angezeigt.', 'piero-fracasso-emails'),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'only_ch_li' => array(
                'title'   => __('Restrict to CH/LI', 'piero-fracasso-emails'),
                'type'    => 'checkbox',
                'label'   => __('Only allow billing addresses in Switzerland or Liechtenstein', 'piero-fracasso-emails'),
                'default' => 'yes',
            ),
            'min_amount' => array(
                'title'       => __('Minimum Amount (CHF)', 'piero-fracasso-emails'),
                'type'        => 'number',
                'description' => __('Minimum order total required to show this gateway.', 'piero-fracasso-emails'),
                'default'     => '0.05',
                'desc_tip'    => true,
            ),
            'payment_notice' => array(
                'title'       => __('Payment Notice', 'piero-fracasso-emails'),
                'type'        => 'textarea',
                'description' => __('Shown on the invoice and emails.', 'piero-fracasso-emails'),
                'default'     => __('Der Rechnungsbetrag ist sofort nach Erhalt zahlbar.', 'piero-fracasso-emails'),
            ),
            'qr_iban' => array(
                'title'       => __('QR-IBAN', 'piero-fracasso-emails'),
                'type'        => 'text',
                'description' => __('Required to generate Swiss QR invoices.', 'piero-fracasso-emails'),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'creditor_name' => array(
                'title'       => __('Creditor Name', 'piero-fracasso-emails'),
                'type'        => 'text',
                'default'     => '',
            ),
            'creditor_street' => array(
                'title'   => __('Creditor Street and No.', 'piero-fracasso-emails'),
                'type'    => 'text',
                'default' => '',
            ),
            'creditor_postcode' => array(
                'title'   => __('Creditor ZIP', 'piero-fracasso-emails'),
                'type'    => 'text',
                'default' => '',
            ),
            'creditor_city' => array(
                'title'   => __('Creditor City', 'piero-fracasso-emails'),
                'type'    => 'text',
                'default' => '',
            ),
            'creditor_country' => array(
                'title'   => __('Creditor Country (ISO-2)', 'piero-fracasso-emails'),
                'type'    => 'text',
                'default' => 'CH',
            ),
            'reference_schema' => array(
                'title'       => __('Reference Schema', 'piero-fracasso-emails'),
                'type'        => 'text',
                'description' => __('Used to build the payment reference.', 'piero-fracasso-emails'),
                'default'     => 'PFP-{order_id}',
                'desc_tip'    => true,
            ),
            'attach_customer_invoice' => array(
                'title'   => __('Attach to customer invoice email', 'piero-fracasso-emails'),
                'type'    => 'checkbox',
                'label'   => __('Attach PDF to customer invoice email', 'piero-fracasso-emails'),
                'default' => 'yes',
            ),
            'attach_customer_order_received' => array(
                'title'   => __('Attach to order confirmation email', 'piero-fracasso-emails'),
                'type'    => 'checkbox',
                'label'   => __('Attach PDF to order confirmation email', 'piero-fracasso-emails'),
                'default' => 'yes',
            ),
            'attach_customer_processing_order' => array(
                'title'   => __('Attach to processing order email', 'piero-fracasso-emails'),
                'type'    => 'checkbox',
                'label'   => __('Attach PDF to processing order email', 'piero-fracasso-emails'),
                'default' => 'yes',
            ),
            'attach_customer_order_shipped' => array(
                'title'   => __('Attach to shipped order email', 'piero-fracasso-emails'),
                'type'    => 'checkbox',
                'label'   => __('Attach PDF to shipped order email', 'piero-fracasso-emails'),
                'default' => 'yes',
            ),
            'cache_pdf' => array(
                'title'   => __('Cache PDF per order', 'piero-fracasso-emails'),
                'type'    => 'checkbox',
                'label'   => __('Only generate the PDF once per order', 'piero-fracasso-emails'),
                'default' => 'yes',
            ),
            'checkout_diagnostics' => array(
                'title'   => __('Diagnose im Checkout für Admins', 'piero-fracasso-emails'),
                'type'    => 'checkbox',
                'label'   => __('Show diagnostic info in checkout for administrators', 'piero-fracasso-emails'),
                'default' => 'no',
            ),
        );
    }

    /**
     * Retrieve the gateway icon markup.
     *
     * @return string
     */
    public function get_icon()
    {
        $icon_url = trim($this->get_option('icon_url'));
        if (!empty($icon_url)) {
            $response = wp_remote_head($icon_url, array('timeout' => 2));
            if (!is_wp_error($response)) {
                $code = wp_remote_retrieve_response_code($response);
                if ($code >= 200 && $code < 400) {
                    $html = '<img src="' . esc_url($icon_url) . '" alt="" style="max-height:1em;width:auto;" />';
                    return apply_filters('woocommerce_gateway_icon', $html, $this->id);
                }
            }
        }

        $relative = '../assets/img/qr-gateway-icon.png';
        $path     = plugin_dir_path(__FILE__) . $relative;
        if (file_exists($path)) {
            $url  = plugins_url($relative, __FILE__);
            $html = '<img src="' . esc_url($url) . '" alt="" style="max-height:1em;width:auto;" />';
            return apply_filters('woocommerce_gateway_icon', $html, $this->id);
        }

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><rect fill="#777" width="24" height="24"/><path fill="#fff" d="M4 5h16v2H4zm0 4h16v2H4zm0 4h10v2H4zm0 4h10v2H4z"/></svg>';
        $allowed = array(
            'svg'  => array(
                'xmlns'       => true,
                'viewBox'     => true,
                'width'       => true,
                'height'      => true,
                'aria-hidden' => true,
            ),
            'rect' => array(
                'fill'  => true,
                'width' => true,
                'height'=> true,
            ),
            'path' => array(
                'fill' => true,
                'd'    => true,
            ),
        );
        $svg = wp_kses($svg, $allowed);

        return apply_filters('woocommerce_gateway_icon', $svg, $this->id);
    }

    /**
     * Check gateway availability.
     *
     * @return bool
     */
    public function is_available()
    {
        $this->unavailability_reasons = array();

        if ('yes' !== $this->get_option('enabled')) {
            return false;
        }

        if (!function_exists('WC')) {
            $this->unavailability_reasons[] = 'no_wc';
            return false;
        }

        if ('CHF' !== get_woocommerce_currency()) {
            return $this->unavailable('currency');
        }

        $min = (float) apply_filters('pfp_invoice_min_amount', $this->get_option('min_amount', 0.05));
        if (WC()->cart && WC()->cart->total < $min) {
            return $this->unavailable('min_amount');
        }

        if ('yes' === $this->get_option('only_ch_li') && WC()->customer) {
            $country = WC()->customer->get_billing_country();
            if (!in_array($country, array('CH', 'LI'), true)) {
                return $this->unavailable('country');
            }
        }

        $iban = $this->get_option('qr_iban');
        if (empty($iban)) {
            return $this->unavailable('iban');
        }

        return apply_filters('pfp_invoice_is_available', true, $this);
    }

    /**
     * Mark the gateway as unavailable for a reason.
     *
     * @param string $code Reason code.
     * @return bool
     */
    protected function unavailable($code)
    {
        $this->unavailability_reasons[] = $code;

        $force = apply_filters('pfp_invoice_force_visible', false, $this);
        if ($force && current_user_can('manage_woocommerce')) {
            return true;
        }

        return false;
    }

    /**
     * Process the payment and return the result.
     *
     * @param int $order_id Order ID.
     * @return array
     */
    public function process_payment($order_id)
    {
        $order = wc_get_order($order_id);

        if (!$this->validate_order($order)) {
            wc_add_notice(__('Swiss QR invoice payment is not available for this order.', 'piero-fracasso-emails'), 'error');
            return array('result' => 'failure');
        }

        $order->update_status('invoice');
        $order->save();

        return array(
            'result'   => 'success',
            'redirect' => $this->get_return_url($order),
        );
    }

    /**
     * Validate order against gateway requirements.
     *
     * @param WC_Order $order Order object.
     * @return bool
     */
    protected function validate_order($order)
    {
        if (!$order instanceof WC_Order) {
            return false;
        }

        if ('CHF' !== $order->get_currency()) {
            return false;
        }

        if ('yes' === $this->get_option('only_ch_li')) {
            $country = $order->get_billing_country();
            if (!in_array($country, array('CH', 'LI'), true)) {
                return false;
            }
        }

        $min = (float) $this->get_option('min_amount', 0.05);
        if ($order->get_total() < $min) {
            return false;
        }

        $iban = $this->get_option('qr_iban');
        if (empty($iban)) {
            return false;
        }

        return true;
    }

    /**
     * Output checkout diagnostics for administrators.
     */
    public function maybe_render_checkout_diagnostics()
    {
        if ('yes' !== $this->get_option('checkout_diagnostics')) {
            return;
        }

        if (!current_user_can('manage_woocommerce')) {
            return;
        }

        if (empty($this->unavailability_reasons)) {
            return;
        }

        $messages = array(
            'currency'   => __('Shop currency ≠ CHF', 'piero-fracasso-emails'),
            'country'    => __('Billing Country not CH/LI', 'piero-fracasso-emails'),
            'min_amount' => __('Minimum amount not reached', 'piero-fracasso-emails'),
            'iban'       => __('QR-IBAN missing', 'piero-fracasso-emails'),
        );

        $reasons = array();
        foreach ($this->unavailability_reasons as $code) {
            if (isset($messages[$code])) {
                $reasons[] = $messages[$code];
            }
        }

        if (!empty($reasons)) {
            echo '<div class="notice notice-info"><p>' . esc_html__('Swiss QR invoice hidden:', 'piero-fracasso-emails') . ' ' . esc_html(implode(', ', $reasons)) . '</p></div>';
        }
    }
}

/**
 * Attach invoice PDF to emails.
 *
 * @param array    $attachments Existing attachments.
 * @param string   $email_id    Email ID.
 * @param WC_Order $order       Order object.
 * @return array
 */
function bypf_invoice_email_attachments($attachments, $email_id, $order)
{
    if (!$order instanceof WC_Order) {
        return $attachments;
    }

    if ($order->get_payment_method() !== 'pfp_invoice') {
        return $attachments;
    }

    $gateway = null;
    if (function_exists('WC')) {
        $gateways = WC()->payment_gateways()->payment_gateways();
        $gateway  = isset($gateways['pfp_invoice']) ? $gateways['pfp_invoice'] : null;
    }
    if (!$gateway instanceof PFP_Gateway_Invoice) {
        return $attachments;
    }

    $enabled_emails = array();
    if ('yes' === $gateway->get_option('attach_customer_invoice')) {
        $enabled_emails[] = 'customer_invoice';
    }
    if ('yes' === $gateway->get_option('attach_customer_order_received')) {
        $enabled_emails[] = 'customer_order_received';
    }
    if ('yes' === $gateway->get_option('attach_customer_processing_order')) {
        $enabled_emails[] = 'customer_processing_order';
    }
    if ('yes' === $gateway->get_option('attach_customer_order_shipped')) {
        $enabled_emails[] = 'customer_order_shipped';
    }

    $enabled_emails = apply_filters('pfp_invoice_attach_email_ids', $enabled_emails);
    if (!in_array($email_id, $enabled_emails, true)) {
        return $attachments;
    }

    $pdf = bypf_invoice_generate_pdf($order, $gateway);
    if ($pdf) {
        $attachments[] = $pdf;
    }

    return $attachments;
}
add_filter('woocommerce_email_attachments', 'bypf_invoice_email_attachments', 10, 3);

/**
 * Generate invoice PDF.
 *
 * @param WC_Order            $order   Order object.
 * @param PFP_Gateway_Invoice $gateway Gateway instance.
 * @return string|false Path to PDF or false.
 */
function bypf_invoice_generate_pdf($order, $gateway)
{
    if ('CHF' !== $order->get_currency()) {
        return false;
    }

    $iban = $gateway->get_option('qr_iban');
    if (empty($iban)) {
        bypf_log('Missing QR-IBAN for invoice gateway', 'warning');
        return false;
    }

    $upload = wp_upload_dir();
    $filename = apply_filters('pfp_invoice_pdf_filename', 'pfp-invoice-' . $order->get_id() . '.pdf', $order);
    $filepath = trailingslashit($upload['path']) . $filename;

    if ('yes' === $gateway->get_option('cache_pdf') && file_exists($filepath)) {
        return $filepath;
    }

    if (!class_exists('QR_Invoice_Service')) {
        bypf_log('QR_Invoice_Service not available', 'error');
        return false;
    }

    $service = new QR_Invoice_Service();
    if (method_exists($service, 'generate')) {
        $reference = apply_filters('pfp_invoice_reference_schema', str_replace('{order_id}', $order->get_id(), $gateway->get_option('reference_schema', 'PFP-{order_id}')), $order);
        $service->generate(
            $order,
            array(
                'iban'     => $iban,
                'creditor' => array(
                    'name'    => $gateway->get_option('creditor_name'),
                    'street'  => $gateway->get_option('creditor_street'),
                    'zip'     => $gateway->get_option('creditor_postcode'),
                    'city'    => $gateway->get_option('creditor_city'),
                    'country' => $gateway->get_option('creditor_country'),
                ),
                'message'  => $gateway->get_option('payment_notice'),
                'amount'   => $order->get_total(),
                'currency' => $order->get_currency(),
                'reference' => $reference,
                'filename' => $filepath,
            )
        );
    }

    if (file_exists($filepath)) {
        do_action('pfp_invoice_pdf_generated', $order->get_id(), $filepath);
        return $filepath;
    }

    return false;
}
