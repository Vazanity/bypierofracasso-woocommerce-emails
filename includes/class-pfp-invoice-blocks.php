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

    protected function get_gateway_id()
    {
        return PFP_GATEWAY_ID;
    }

    protected function is_logging_enabled()
    {
        return \function_exists('bypf_invoice_logging_enabled') && \bypf_invoice_logging_enabled();
    }

    public function get_name()
    {
        return $this->get_gateway_id();
    }

    public function initialize()
    {
        $this->settings = get_option('woocommerce_' . $this->get_gateway_id() . '_settings', array());
    }

    public function is_active()
    {
        $log_enabled = $this->is_logging_enabled();

        $enabled = isset($this->settings['enabled']) && 'yes' === $this->settings['enabled'];
        if ($log_enabled) {
            \bypf_invoice_log_admin('Blocks is_active(): enabled setting = ' . ($enabled ? 'yes' : 'no'));
        }
        if (!$enabled) {
            if ($log_enabled) {
                \bypf_invoice_log_admin('Blocks is_active(): failing because gateway is disabled.');
            }
            return false;
        }

        $currency = \function_exists('get_woocommerce_currency') ? get_woocommerce_currency() : '';
        $currency_pass = ('CHF' === $currency);
        if ($log_enabled) {
            \bypf_invoice_log_admin(
                'Blocks is_active(): currency check = ' . ($currency_pass ? 'pass' : 'fail') . ' (' . ($currency ?: 'n/a') . ')'
            );
        }
        if (!$currency_pass) {
            return false;
        }

        $restrict = isset($this->settings['only_ch_li']) && 'yes' === $this->settings['only_ch_li'];
        $country_value = '';
        $country_pass  = true;

        if ($restrict && \function_exists('WC')) {
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

        if ($restrict && !$country_pass) {
            return false;
        }

        $min_setting = isset($this->settings['min_amount']) ? $this->settings['min_amount'] : '';
        $min_amount  = is_numeric($min_setting) ? (float) $min_setting : 0.0;

        if ($log_enabled) {
            $note = $min_amount > 0 ? 'requires frontend evaluation' : 'no minimum configured';
            \bypf_invoice_log_admin('Blocks is_active(): minimum amount setting = ' . $min_amount . ' (' . $note . ')');
        }

        if ($log_enabled) {
            \bypf_invoice_log_admin('Blocks is_active(): final result = true.');
        }

        return true;
    }

    public function get_payment_method_script_handles()
    {
        $registered = \wp_script_is('pfp-invoice-blocks', 'registered');

        if (!$registered) {
            if (\current_user_can('manage_woocommerce') && \function_exists('is_checkout') && \is_checkout()) {
                if (!\has_action('admin_notices', '\bypf_invoice_blocks_missing_script_notice')) {
                    \add_action('admin_notices', '\bypf_invoice_blocks_missing_script_notice');
                }
                if (!\has_action('wp_footer', '\bypf_invoice_blocks_missing_script_notice')) {
                    \add_action('wp_footer', '\bypf_invoice_blocks_missing_script_notice');
                }
            }

            if ($this->is_logging_enabled()) {
                \bypf_invoice_log_admin('Blocks get_payment_method_script_handles(): script handle missing.');
            }

            return array();
        }

        if ($this->is_logging_enabled() && !\wp_script_is('pfp-invoice-blocks', 'enqueued')) {
            \bypf_invoice_log_admin('pfp-invoice-blocks registered but not enqueued — verify Blocks integration');
        }

        return array('pfp-invoice-blocks');
    }
}
