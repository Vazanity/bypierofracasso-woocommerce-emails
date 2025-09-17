<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Returns a filesystem path to the generated invoice PDF for the given order,
 * or an empty string if generation is not available.
 */
function pfp_get_invoice_pdf_path(WC_Order $order): string
{
    if (function_exists('pfp_qr_invoice_generate_pdf')) {
        try {
            $path = pfp_qr_invoice_generate_pdf($order);
            return (is_string($path) && file_exists($path)) ? $path : '';
        } catch (Throwable $e) {
            if (function_exists('pfp_log')) {
                pfp_log('[PFP] PDF generation failed: ' . $e->getMessage(), 'error');
            }
            return '';
        }
    }

    if (function_exists('bypf_invoice_generate_pdf')) {
        try {
            if (function_exists('bypf_include_invoice_gateway_class')) {
                bypf_include_invoice_gateway_class();
            }

            $gateway = null;
            if (function_exists('WC')) {
                $wc = WC();
                if ($wc && method_exists($wc, 'payment_gateways')) {
                    $gateways_instance = $wc->payment_gateways();
                    if ($gateways_instance && method_exists($gateways_instance, 'payment_gateways')) {
                        $gateways = $gateways_instance->payment_gateways();
                        if (isset($gateways[PFP_GATEWAY_ID])) {
                            $gateway = $gateways[PFP_GATEWAY_ID];
                        }
                    }
                }
            }

            if (!$gateway instanceof PFP_Gateway_Invoice) {
                return '';
            }

            $path = bypf_invoice_generate_pdf($order, $gateway);
            return (is_string($path) && file_exists($path)) ? $path : '';
        } catch (Throwable $e) {
            if (function_exists('pfp_log')) {
                pfp_log('[PFP] PDF generation failed: ' . $e->getMessage(), 'error');
            }
            return '';
        }
    }

    if (function_exists('pfp_log')) {
        pfp_log('[PFP] No PDF generator available for invoice.', 'warning');
    }
    return '';
}
