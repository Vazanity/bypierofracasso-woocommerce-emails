<?php
namespace PFP\Blocks;

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

if (!defined('ABSPATH')) {
    exit;
}

class PFP_Invoice_Blocks extends AbstractPaymentMethodType
{
    /** @var array */
    protected $settings = array();

    protected function is_logging_enabled(): bool
    {
        return \function_exists('bypf_invoice_logging_enabled') && \bypf_invoice_logging_enabled();
    }

    public function get_name(): string
    {
        return 'pfp_invoice';
    }

    public function initialize(): void
    {
        $this->settings = get_option('woocommerce_pfp_invoice_settings', array());
    }

    public function is_active(): bool
    {
        $log_enabled = $this->is_logging_enabled();

        $enabled = isset($this->settings['enabled']) && 'yes' === $this->settings['enabled'];
        if ($log_enabled) {
            \bypf_invoice_log_admin('Blocks is_active(): enabled setting = ' . ($enabled ? 'yes' : 'no'));
        }

        $is_active = $enabled;

        if ($is_active) {
            $currency      = \function_exists('get_woocommerce_currency') ? get_woocommerce_currency() : '';
            $currency_pass = ('CHF' === $currency);

            if ($log_enabled) {
                \bypf_invoice_log_admin(
                    'Blocks is_active(): currency check = ' . ($currency_pass ? 'pass' : 'fail') . ' (' . ($currency ?: 'n/a') . ')'
                );
            }

            if (!$currency_pass) {
                $is_active = false;
            }
        }

        $restrict      = isset($this->settings['only_ch_li']) && 'yes' === $this->settings['only_ch_li'];
        $country_value = '';
        $country_pass  = true;

        if ($is_active && $restrict && \function_exists('WC')) {
            $customer = \WC()->customer;
            if ($customer) {
                $country_value = $customer->get_billing_country();
                if ('' === $country_value) {
                    $country_value = $customer->get_shipping_country();
                }
                $country_pass = ('' === $country_value || in_array($country_value, array('CH', 'LI'), true));
            }
        }

        if ($log_enabled) {
            $message = 'Blocks is_active(): country check = ' . ($country_pass ? 'pass' : 'fail');
            if (!$restrict) {
                $message .= ' (restriction disabled)';
            }
            $message .= ' (' . ($country_value ?: 'empty') . ')';
            \bypf_invoice_log_admin($message);
        }

        if ($is_active && $restrict && !$country_pass) {
            $is_active = false;
        }

        $min_setting = isset($this->settings['min_amount']) ? $this->settings['min_amount'] : '';
        $min_amount  = is_numeric($min_setting) ? (float) $min_setting : 0.0;

        if ($log_enabled) {
            $note = $min_amount > 0 ? 'requires frontend evaluation' : 'no minimum configured';
            \bypf_invoice_log_admin('Blocks is_active(): minimum amount setting = ' . $min_amount . ' (' . $note . ')');
        }

        if ($log_enabled) {
            \bypf_invoice_log_admin('Blocks is_active(): final result = ' . ($is_active ? 'true' : 'false') . '.');
        }

        return true === $is_active;
    }

    public function get_payment_method_script_handles(): array
    {
        return array('pfp-invoice-blocks');
    }

    public function get_payment_method_data(): array
    {
        return array(
            'title'       => __('Rechnung (Swiss QR)', 'bypierofracasso-woocommerce-emails'),
            'description' => __('Bezahlen Sie per Rechnung/Swiss-QR nach Erhalt.', 'bypierofracasso-woocommerce-emails'),
            'minAmount'   => 0.05,
            'currency'    => \function_exists('get_woocommerce_currency') ? get_woocommerce_currency() : '',
        );
    }
}
