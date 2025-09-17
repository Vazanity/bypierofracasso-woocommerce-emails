<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Piero Fracasso Perfumes Invoice Payment Gateway.
 */
class PFP_Gateway_Invoice extends WC_Payment_Gateway
{
    private const DEFAULT_TITLE = 'Invoice (Swiss QR)';

    private const DEFAULT_METHOD_DESCRIPTION = 'This payment method appears only when the store currency is CHF and can optionally be limited to billing addresses in Switzerland or Liechtenstein.';

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
        $this->id                 = PFP_GATEWAY_ID;
        $this->method_title       = self::DEFAULT_TITLE;
        $this->method_description = self::DEFAULT_METHOD_DESCRIPTION;
        $this->title              = self::DEFAULT_TITLE;
        $this->has_fields         = false;
        $this->supports           = array('products');

        $this->init_form_fields();
        $this->init_settings();

        $this->title       = $this->get_option('title', $this->title);
        $this->description = $this->get_option('description');

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        add_action('woocommerce_review_order_after_payment', array($this, 'maybe_render_checkout_diagnostics'));
        add_filter('woocommerce_settings_api_sanitized_fields_' . $this->id, array($this, 'sanitize_admin_settings'));
    }

    /**
     * Get the translated gateway title used in settings screens.
     */
    public function get_method_title()
    {
        $title = $this->method_title;

        if ($title === self::DEFAULT_TITLE) {
            $title = __('Invoice (Swiss QR)', 'bypierofracasso-woocommerce-emails');
        }

        return apply_filters('woocommerce_gateway_title', $title, $this->id);
    }

    /**
     * Get the translated gateway title shown at checkout.
     */
    public function get_title()
    {
        $title = $this->title;

        if ($title === self::DEFAULT_TITLE) {
            $title = __('Invoice (Swiss QR)', 'bypierofracasso-woocommerce-emails');
        }

        return apply_filters('woocommerce_gateway_title', $title, $this->id);
    }

    /**
     * Get the translated description used in admin screens.
     */
    public function get_method_description()
    {
        $description = $this->method_description;

        if ($description === self::DEFAULT_METHOD_DESCRIPTION) {
            $description = __('This payment method appears only when the store currency is CHF and can optionally be limited to billing addresses in Switzerland or Liechtenstein.', 'bypierofracasso-woocommerce-emails');
        }

        return $description;
    }

    /**
     * Get the translated description shown to the customer.
     */
    public function get_description()
    {
        $description = $this->description;

        if ('' === $description || null === $description) {
            $description = $this->method_description;
        }

        if ($description === self::DEFAULT_METHOD_DESCRIPTION) {
            $description = __('This payment method appears only when the store currency is CHF and can optionally be limited to billing addresses in Switzerland or Liechtenstein.', 'bypierofracasso-woocommerce-emails');
        }

        return apply_filters('woocommerce_gateway_description_' . $this->id, $description, $this);
    }

    /**
     * Initialize form fields.
     */
    public function init_form_fields()
    {
        $this->form_fields = array(
            'enabled' => array(
                'title'   => __('Enable/Disable', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'checkbox',
                'label'   => __('Enable Swiss QR invoice payments', 'bypierofracasso-woocommerce-emails'),
                'default' => 'no',
            ),
            'title' => array(
                'title'       => __('Title', 'bypierofracasso-woocommerce-emails'),
                'type'        => 'text',
                'description' => __('Displayed on the checkout page.', 'bypierofracasso-woocommerce-emails'),
                'default'     => __('Rechnung (Swiss QR)', 'bypierofracasso-woocommerce-emails'),
                'desc_tip'    => true,
            ),
            'description' => array(
                'title'       => __('Description', 'bypierofracasso-woocommerce-emails'),
                'type'        => 'textarea',
            'description' => __('Checkout description shown to the customer.', 'bypierofracasso-woocommerce-emails'),
            'default'     => __('Sie erhalten eine Rechnung mit Swiss-QR-Code im Anhang der Bestellbestätigung.', 'bypierofracasso-woocommerce-emails'),
        ),
            'only_ch_li' => array(
                'title'   => __('Restrict to CH/LI', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'checkbox',
                'label'   => __('Only allow billing addresses in Switzerland or Liechtenstein', 'bypierofracasso-woocommerce-emails'),
                'default' => 'yes',
            ),
            'min_amount' => array(
                'title'       => __('Minimum Amount (CHF)', 'bypierofracasso-woocommerce-emails'),
                'type'        => 'number',
                'description' => __('Minimum order total required to show this gateway.', 'bypierofracasso-woocommerce-emails'),
                'default'     => '0.05',
                'desc_tip'    => true,
            ),
            'payment_notice' => array(
                'title'       => __('Payment Notice', 'bypierofracasso-woocommerce-emails'),
                'type'        => 'textarea',
                'description' => __('Shown on the invoice and emails.', 'bypierofracasso-woocommerce-emails'),
                'default'     => __('Der Rechnungsbetrag ist sofort nach Erhalt zahlbar.', 'bypierofracasso-woocommerce-emails'),
            ),
            'qr_iban' => array(
                'title'       => __('QR-IBAN', 'bypierofracasso-woocommerce-emails'),
                'type'        => 'text',
                'description' => __('Optional when an IBAN is configured; required for QR references.', 'bypierofracasso-woocommerce-emails'),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'iban' => array(
                'title'       => __('IBAN', 'bypierofracasso-woocommerce-emails'),
                'type'        => 'text',
                'description' => __('Used when no QR-IBAN is provided.', 'bypierofracasso-woocommerce-emails'),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'creditor_reference' => array(
                'title'       => __('Creditor Reference', 'bypierofracasso-woocommerce-emails'),
                'type'        => 'text',
                'description' => __('Optional; start with RF for SCOR references.', 'bypierofracasso-woocommerce-emails'),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'creditor_name' => array(
                'title'       => __('Creditor Name', 'bypierofracasso-woocommerce-emails'),
                'type'        => 'text',
                'default'     => '',
            ),
            'creditor_street' => array(
                'title'   => __('Creditor Street and No.', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'text',
                'default' => '',
            ),
            'creditor_postcode' => array(
                'title'   => __('Creditor ZIP', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'text',
                'default' => '',
            ),
            'creditor_city' => array(
                'title'   => __('Creditor City', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'text',
                'default' => '',
            ),
            'creditor_country' => array(
                'title'   => __('Creditor Country (ISO-2)', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'text',
                'default' => 'CH',
            ),
            'reference_schema' => array(
                'title'       => __('Reference Schema', 'bypierofracasso-woocommerce-emails'),
                'type'        => 'text',
                'description' => __('Used to build the payment reference.', 'bypierofracasso-woocommerce-emails'),
                'default'     => 'PFP-{order_id}',
                'desc_tip'    => true,
            ),
            'attach_customer_invoice' => array(
                'title'   => __('Attach to customer invoice email', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'checkbox',
                'label'   => __('Attach PDF to customer invoice email', 'bypierofracasso-woocommerce-emails'),
                'default' => 'yes',
            ),
            'attach_customer_order_received' => array(
                'title'   => __('Attach to order confirmation email', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'checkbox',
                'label'   => __('Attach PDF to order confirmation email', 'bypierofracasso-woocommerce-emails'),
                'default' => 'yes',
            ),
            'attach_customer_processing_order' => array(
                'title'   => __('Attach to processing order email', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'checkbox',
                'label'   => __('Attach PDF to processing order email', 'bypierofracasso-woocommerce-emails'),
                'default' => 'yes',
            ),
            'attach_customer_order_shipped' => array(
                'title'   => __('Attach to shipped order email', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'checkbox',
                'label'   => __('Attach PDF to shipped order email', 'bypierofracasso-woocommerce-emails'),
                'default' => 'yes',
            ),
            'cache_pdf' => array(
                'title'   => __('Cache PDF per order', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'checkbox',
                'label'   => __('Only generate the PDF once per order', 'bypierofracasso-woocommerce-emails'),
                'default' => 'yes',
            ),
            'checkout_diagnostics' => array(
                'title'   => __('Diagnose im Checkout für Admins', 'bypierofracasso-woocommerce-emails'),
                'type'    => 'checkbox',
                'label'   => __('Show diagnostic info in checkout for administrators', 'bypierofracasso-woocommerce-emails'),
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
                WC_Admin_Settings::add_error(__('Please enter at least a QR-IBAN or an IBAN for the invoice gateway.', 'bypierofracasso-woocommerce-emails'));
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

        $log_enabled = function_exists('bypf_invoice_logging_enabled') && bypf_invoice_logging_enabled();

        $enabled = ('yes' === $this->get_option('enabled', 'no'));
        if ($log_enabled) {
            bypf_invoice_log_admin('Classic is_available(): enabled setting = ' . ($enabled ? 'yes' : 'no'));
        }
        if (!$enabled) {
            $this->unavailability_reasons[] = 'disabled';
            if ($log_enabled) {
                bypf_invoice_log_admin('Classic is_available(): failing because gateway is disabled.');
            }
            return false;
        }

        $currency = function_exists('get_woocommerce_currency') ? get_woocommerce_currency() : '';
        $currency_pass = ('CHF' === $currency);
        if ($log_enabled) {
            bypf_invoice_log_admin(
                'Classic is_available(): currency check = ' . ($currency_pass ? 'pass' : 'fail') . ' (' . ($currency ?: 'n/a') . ')'
            );
        }
        if (!$currency_pass) {
            $this->unavailability_reasons[] = 'currency';
            return false;
        }

        $restrict_to_ch_li = ('yes' === $this->get_option('only_ch_li', 'no'));
        $country_value      = '';
        $country_pass       = true;

        if ($restrict_to_ch_li) {
            if (function_exists('WC') && WC()->customer) {
                $country_value = WC()->customer->get_billing_country();
                if ('' === $country_value) {
                    $country_value = WC()->customer->get_shipping_country();
                }
            }

            $country_pass = ('' === $country_value || in_array($country_value, array('CH', 'LI'), true));
            if (!$country_pass) {
                $this->unavailability_reasons[] = 'country';
            }
        }

        if ($log_enabled) {
            $message = 'Classic is_available(): country check = ' . ($country_pass ? 'pass' : 'fail');
            if (!$restrict_to_ch_li) {
                $message .= ' (restriction disabled)';
            }
            $message .= ' (' . ($country_value ?: 'empty') . ')';
            bypf_invoice_log_admin($message);
        }

        if (!$country_pass) {
            return false;
        }

        $min_setting = $this->get_option('min_amount', '');
        $min_amount  = is_numeric($min_setting) ? (float) $min_setting : 0.0;
        if ($log_enabled) {
            bypf_invoice_log_admin('Classic is_available(): minimum amount setting = ' . $min_amount);
        }

        if ($min_amount > 0) {
            $cart_total = null;

            if (function_exists('WC') && WC()->cart) {
                $raw_total = null;
                if (is_callable(array(WC()->cart, 'get_total'))) {
                    $raw_total = WC()->cart->get_total('edit');
                } elseif (isset(WC()->cart->total)) {
                    $raw_total = WC()->cart->total;
                }

                if (is_string($raw_total)) {
                    if (function_exists('wc_format_decimal')) {
                        $raw_total = wc_format_decimal(
                            $raw_total,
                            function_exists('wc_get_price_decimals') ? wc_get_price_decimals() : 2,
                            false
                        );
                    } else {
                        $raw_total = str_replace(',', '.', preg_replace('/[^0-9\\.,-]/', '', $raw_total));
                    }
                }

                if (is_numeric($raw_total)) {
                    $cart_total = (float) $raw_total;
                }
            }

            if (null === $cart_total && function_exists('WC') && WC()->session) {
                $totals = WC()->session->get('cart_totals');
                if (is_array($totals) && isset($totals['total'])) {
                    $session_total = $totals['total'];
                    if (is_string($session_total)) {
                        if (function_exists('wc_format_decimal')) {
                            $session_total = wc_format_decimal(
                                $session_total,
                                function_exists('wc_get_price_decimals') ? wc_get_price_decimals() : 2,
                                false
                            );
                        } else {
                            $session_total = str_replace(',', '.', preg_replace('/[^0-9\\.,-]/', '', $session_total));
                        }
                    }

                    if (is_numeric($session_total)) {
                        $cart_total = (float) $session_total;
                    }
                }
            }

            if ($log_enabled) {
                bypf_invoice_log_admin(
                    'Classic is_available(): min total evaluation = ' . (null === $cart_total ? 'unavailable' : sprintf('%.2f', $cart_total))
                );
            }

            if (null !== $cart_total && $cart_total < $min_amount) {
                $this->unavailability_reasons[] = 'min_amount';
                if ($log_enabled) {
                    bypf_invoice_log_admin(sprintf('Classic is_available(): failing min check %.2f < %.2f', $cart_total, $min_amount));
                }
                return false;
            }
        }

        $available = apply_filters('pfp_invoice_is_available', true, $this);

        if (!$available && empty($this->unavailability_reasons)) {
            $this->unavailability_reasons[] = 'filtered';
            if ($log_enabled) {
                bypf_invoice_log_admin('Classic is_available(): filtered result forced to false.');
            }
        }

        if ($log_enabled) {
            bypf_invoice_log_admin('Classic is_available(): final result = ' . ($available ? 'true' : 'false'));
        }

        return $available;
    }

    /**
     * Retrieve the last recorded unavailability reasons.
     *
     * @return array
     */
    public function get_last_unavailability_reasons()
    {
        return $this->unavailability_reasons;
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
            wc_add_notice(__('Swiss QR invoice payment is not available for this order.', 'bypierofracasso-woocommerce-emails'), 'error');
            return array('result' => 'failure');
        }

        $payment_parameters = $this->get_payment_parameters($order);
        if (empty($payment_parameters['account'])) {
            wc_add_notice(__('Swiss QR invoice configuration is incomplete.', 'bypierofracasso-woocommerce-emails'), 'error');
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
            'disabled'   => __('Gateway disabled in settings', 'bypierofracasso-woocommerce-emails'),
            'currency'   => __('Shop currency ≠ CHF', 'bypierofracasso-woocommerce-emails'),
            'country'    => __('Billing Country not CH/LI', 'bypierofracasso-woocommerce-emails'),
            'min_amount' => __('Minimum amount not reached', 'bypierofracasso-woocommerce-emails'),
            'filtered'   => __('Hidden by customization filter', 'bypierofracasso-woocommerce-emails'),
        );

        $reasons = array();
        foreach ($this->unavailability_reasons as $code) {
            if (isset($messages[$code])) {
                $reasons[] = $messages[$code];
            }
        }

        if (!empty($reasons)) {
            echo '<div class="notice notice-info"><p>' . esc_html__('Swiss QR invoice hidden:', 'bypierofracasso-woocommerce-emails') . ' ' . esc_html(implode(', ', $reasons)) . '</p></div>';
        }
    }
}

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
