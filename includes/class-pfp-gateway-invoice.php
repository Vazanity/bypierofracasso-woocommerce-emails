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
        $this->method_description = __('Diese Zahlungsmethode erscheint nur bei Währung CHF und (optional) für Adressen in CH oder LI.', 'piero-fracasso-emails');
        $this->title              = __('Rechnung (Swiss QR)', 'piero-fracasso-emails');
        $this->has_fields = false;
        $this->supports   = array('products', 'refunds');

        $this->init_form_fields();
        $this->init_settings();

        $this->title       = $this->get_option('title', $this->title);
        $this->description = $this->get_option('description');

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        add_action('woocommerce_review_order_after_payment', array($this, 'maybe_render_checkout_diagnostics'));
        add_filter('woocommerce_settings_api_sanitized_fields_' . $this->id, array($this, 'sanitize_admin_settings'));
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
                'description' => __('Optional when an IBAN is configured; required for QR references.', 'piero-fracasso-emails'),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'iban' => array(
                'title'       => __('IBAN', 'piero-fracasso-emails'),
                'type'        => 'text',
                'description' => __('Used when no QR-IBAN is provided.', 'piero-fracasso-emails'),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'creditor_reference' => array(
                'title'       => __('Creditor Reference', 'piero-fracasso-emails'),
                'type'        => 'text',
                'description' => __('Optional; start with RF for SCOR references.', 'piero-fracasso-emails'),
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
     * Sanitize gateway settings before saving.
     *
     * @param array $fields Raw settings fields.
     * @return array
     */
    public function sanitize_admin_settings($fields)
    {
        if (!is_array($fields)) {
            return $fields;
        }

        $text_fields = array(
            'title',
            'qr_iban',
            'iban',
            'creditor_reference',
            'creditor_name',
            'creditor_street',
            'creditor_postcode',
            'creditor_city',
            'creditor_country',
            'reference_schema'
        );

        foreach ($text_fields as $key) {
            if (isset($fields[$key]) && is_string($fields[$key])) {
                $fields[$key] = sanitize_text_field(wp_unslash($fields[$key]));
            }
        }

        if (isset($fields['description']) && is_string($fields['description'])) {
            $fields['description'] = wp_kses_post(wp_unslash($fields['description']));
        }

        if (isset($fields['payment_notice']) && is_string($fields['payment_notice'])) {
            $fields['payment_notice'] = wp_kses_post(wp_unslash($fields['payment_notice']));
        }

        if (isset($fields['min_amount'])) {
            $fields['min_amount'] = wc_format_decimal(wp_unslash($fields['min_amount']));
        }

        return $fields;
    }

    /**
     * Validate and persist admin settings.
     *
     * @return bool
     */
    public function process_admin_options()
    {
        if (!current_user_can('manage_woocommerce')) {
            return false;
        }

        $nonce = isset($_POST['_wpnonce']) ? sanitize_text_field(wp_unslash($_POST['_wpnonce'])) : '';
        if (empty($nonce) || !wp_verify_nonce($nonce, 'woocommerce-settings')) {
            return false;
        }

        $post_data = $this->get_post_data();
        $qr_key   = $this->get_field_key('qr_iban');
        $iban_key = $this->get_field_key('iban');
        $qr_iban  = isset($post_data[$qr_key]) ? sanitize_text_field(wp_unslash($post_data[$qr_key])) : '';
        $iban     = isset($post_data[$iban_key]) ? sanitize_text_field(wp_unslash($post_data[$iban_key])) : '';

        if ('' === $qr_iban && '' === $iban) {
            if (class_exists('WC_Admin_Settings')) {
                WC_Admin_Settings::add_error(__('Please enter at least a QR-IBAN or an IBAN for the invoice gateway.', 'piero-fracasso-emails'));
            }
            return false;
        }

        return parent::process_admin_options();
    }

    /**
     * Retrieve the gateway icon markup.
     *
     * @return string
     */
    public function get_icon()
    {
        return '';
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

        if ('CHF' !== get_woocommerce_currency()) {
            return $this->unavailable('currency');
        }

        if ('yes' === $this->get_option('only_ch_li')) {
            $country = '';
            if (function_exists('WC') && WC()->customer) {
                $country = WC()->customer->get_billing_country();
                if (empty($country)) {
                    $country = WC()->customer->get_shipping_country();
                }
            }

            if (!empty($country) && !in_array($country, array('CH', 'LI'), true)) {
                return $this->unavailable('country');
            }
        }

        $min_setting = $this->get_option('min_amount', '');
        $min_amount  = (float) apply_filters('pfp_invoice_min_amount', $min_setting);
        if ($min_amount > 0 && function_exists('WC') && WC()->cart) {
            $total = (float) WC()->cart->total;
            if ($total < $min_amount) {
                return $this->unavailable('min_amount');
            }
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

        if (!$order instanceof WC_Order || !$this->validate_order($order)) {
            wc_add_notice(__('Swiss QR invoice payment is not available for this order.', 'piero-fracasso-emails'), 'error');
            return array('result' => 'failure');
        }

        $payment_parameters = $this->get_payment_parameters($order);
        if (empty($payment_parameters['account'])) {
            wc_add_notice(__('Swiss QR invoice configuration is incomplete.', 'piero-fracasso-emails'), 'error');
            if (function_exists('wc_get_logger')) {
                wc_get_logger()->error('Invoice gateway missing QR-IBAN or IBAN during checkout.', array('source' => 'pfp-invoice'));
            }
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
            if (empty($country)) {
                $country = $order->get_shipping_country();
            }
            if ($country && !in_array($country, array('CH', 'LI'), true)) {
                return false;
            }
        }

        $min_setting = $this->get_option('min_amount', '');
        $min = (float) apply_filters('pfp_invoice_min_amount', $min_setting);
        if ($min > 0 && $order->get_total() < $min) {
            return false;
        }

        return true;
    }

    /**
     * Determine account and reference details for the payment.
     *
     * @param WC_Order|null $order Order context.
     * @return array
     */
    public function get_payment_parameters($order = null)
    {
        $qr_iban            = trim((string) $this->get_option('qr_iban'));
        $iban               = trim((string) $this->get_option('iban'));
        $creditor_reference = trim((string) $this->get_option('creditor_reference'));
        $reference_template = (string) $this->get_option('reference_schema', 'PFP-{order_id}');

        $reference = $reference_template;
        if ($order instanceof WC_Order) {
            $reference = str_replace('{order_id}', $order->get_id(), $reference_template);
        }

        $reference = apply_filters('pfp_invoice_reference_schema', $reference, $order);

        if ($qr_iban !== '') {
            $parameters = array(
                'account'        => $qr_iban,
                'reference_type' => 'QRR',
                'reference'      => $reference,
            );

            return apply_filters('pfp_invoice_payment_parameters', $parameters, $order, $this);
        }

        if ($iban !== '') {
            $type            = 'NON';
            $final_reference = $reference;

            if ($creditor_reference !== '') {
                $final_reference = $creditor_reference;
                if (0 === strpos(strtoupper($creditor_reference), 'RF')) {
                    $type = 'SCOR';
                }
            }

            $parameters = array(
                'account'        => $iban,
                'reference_type' => $type,
                'reference'      => $final_reference,
            );

            return apply_filters('pfp_invoice_payment_parameters', $parameters, $order, $this);
        }

        return apply_filters(
            'pfp_invoice_payment_parameters',
            array(
                'account'        => '',
                'reference_type' => '',
                'reference'      => '',
            ),
            $order,
            $this
        );
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

    $parameters = $gateway->get_payment_parameters($order);
    if (empty($parameters['account'])) {
        if (function_exists('wc_get_logger')) {
            wc_get_logger()->warning('Skipped invoice PDF: no QR-IBAN or IBAN configured.', array('source' => 'pfp-invoice'));
        }
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
        $reference = $parameters['reference'];
        $reference_type = isset($parameters['reference_type']) ? $parameters['reference_type'] : '';
        $service->generate(
            $order,
            array(
                'iban'     => $parameters['account'],
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
                'reference_type' => $reference_type,
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
