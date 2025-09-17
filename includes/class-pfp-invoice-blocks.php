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
            \bypf_invoice_log_admin('Blocks is_active(): store currency = ' . ($currency ?: '(empty)'));
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

        $min_setting = isset($this->settings['min_amount']) ? $this->settings['min_amount'] : '';
        $min_amount  = is_numeric($min_setting) ? (float) $min_setting : 0.0;
        if ($log_enabled) {
            \bypf_invoice_log_admin('Blocks is_active(): minimum amount setting = ' . $min_amount);
        }

        if ($min_amount > 0) {
            $cart_total = null;

            if (\function_exists('WC') && \WC()->session) {
                $totals = \WC()->session->get('cart_totals');
                if (is_array($totals) && isset($totals['total'])) {
                    $session_total = $totals['total'];
                    if (is_string($session_total)) {
                        if (\function_exists('wc_format_decimal')) {
                            $session_total = \wc_format_decimal(
                                $session_total,
                                \function_exists('wc_get_price_decimals') ? \wc_get_price_decimals() : 2,
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
                \bypf_invoice_log_admin(
                    'Blocks is_active(): evaluated cart total = ' . (null === $cart_total ? '(unavailable)' : sprintf('%.2f', $cart_total))
                );
            }

            if (null !== $cart_total && $cart_total < $min_amount) {
                if ($log_enabled) {
                    \bypf_invoice_log_admin(sprintf('Blocks is_active(): cart total %.2f below minimum %.2f.', $cart_total, $min_amount));
                }
                return false;
            } elseif (null !== $cart_total && $log_enabled) {
                \bypf_invoice_log_admin(sprintf('Blocks is_active(): cart total %.2f meets minimum %.2f.', $cart_total, $min_amount));
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
            \bypf_invoice_log_admin('Blocks initialize(): settings loaded.');
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
