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
        return defined('PFP_GATEWAY_ID') ? PFP_GATEWAY_ID : 'pfp_invoice';
    }

    protected function is_logging_enabled()
    {
        return \function_exists('bypf_invoice_logging_enabled') && \bypf_invoice_logging_enabled();
    }

    protected function evaluate_is_active($log_details = true)
    {
        $log_enabled = $log_details && $this->is_logging_enabled();

        $enabled = isset($this->settings['enabled']) && 'yes' === $this->settings['enabled'];
        if ($log_enabled) {
            \bypf_invoice_log_admin('Blocks is_active(): enabled = ' . ($enabled ? 'yes' : 'no'));
        }
        if (!$enabled) {
            if ($log_enabled) {
                \bypf_invoice_log_admin('Blocks is_active(): returning false because gateway is disabled.');
            }
            return false;
        }

        $currency = \function_exists('get_woocommerce_currency') ? get_woocommerce_currency() : '';
        if ($log_enabled) {
            \bypf_invoice_log_admin('Blocks is_active(): store currency = ' . $currency);
        }
        if ('CHF' !== $currency) {
            if ($log_enabled) {
                \bypf_invoice_log_admin('Blocks is_active(): returning false due to non-CHF currency.');
            }
            return false;
        }

        $restrict = isset($this->settings['only_ch_li']) && 'yes' === $this->settings['only_ch_li'];
        if ($log_enabled) {
            \bypf_invoice_log_admin('Blocks is_active(): CH/LI restriction = ' . ($restrict ? 'enabled' : 'disabled'));
        }

        if ($restrict) {
            $country = '';
            if (\function_exists('WC')) {
                $customer = \WC()->customer;
                if ($customer) {
                    $country = $customer->get_billing_country();
                    if (empty($country)) {
                        $country = $customer->get_shipping_country();
                    }
                }
            }

            if ($log_enabled) {
                \bypf_invoice_log_admin('Blocks is_active(): matched customer country = ' . ($country ?: '(empty)'));
            }

            if (!empty($country) && !in_array($country, array('CH', 'LI'), true)) {
                if ($log_enabled) {
                    \bypf_invoice_log_admin('Blocks is_active(): returning false due to country restriction.');
                }
                return false;
            }
        }

        if ($log_enabled) {
            \bypf_invoice_log_admin('Blocks is_active(): final result = true.');
        }

        return true;
    }

    public function get_name()
    {
        return $this->get_gateway_id();
    }

    public function initialize()
    {
        $this->settings = get_option('woocommerce_' . $this->get_gateway_id() . '_settings', array());

        if ($this->is_logging_enabled()) {
            $active = $this->evaluate_is_active(false);
            \bypf_invoice_log_admin('Blocks initialize(): is_active = ' . ($active ? 'true' : 'false'));
        }
    }

    public function is_active()
    {
        return $this->evaluate_is_active(true);
    }

    public function get_payment_method_script_handles()
    {
        return array('pfp-invoice-blocks');
    }
}
