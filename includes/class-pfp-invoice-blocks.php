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

    public function get_name()
    {
        return 'pfp_invoice';
    }

    public function initialize()
    {
        $this->settings = get_option('woocommerce_pfp_invoice_settings', array());
    }

    public function is_active()
    {
        $enabled = isset($this->settings['enabled']) && 'yes' === $this->settings['enabled'];
        if (!$enabled) {
            return false;
        }

        if ('CHF' !== get_woocommerce_currency()) {
            return false;
        }

        if (isset($this->settings['only_ch_li']) && 'yes' === $this->settings['only_ch_li']) {
            $base = wc_get_base_location();
            if (!in_array($base['country'], array('CH', 'LI'), true)) {
                return false;
            }
        }

        return true;
    }

    public function get_payment_method_script_handles()
    {
        return array('pfp-invoice-blocks');
    }
}
