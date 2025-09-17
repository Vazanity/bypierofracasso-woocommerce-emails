<?php
if (!defined('ABSPATH')) {
    exit;
}

function pfp_get_invoice_pdf_path(WC_Order $order): string
{
    if (function_exists('pfp_qr_invoice_generate_pdf')) {
        try {
            $path = pfp_qr_invoice_generate_pdf($order);
            return (is_string($path) && $path && file_exists($path)) ? $path : '';
        } catch (Throwable $e) {
            if (function_exists('pfp_log')) {
                pfp_log('[PFP] PDF generation failed: ' . $e->getMessage(), 'error');
            } else {
                bypf_log('[PFP] PDF generation failed: ' . $e->getMessage(), 'error');
            }
        }
    }

    if (function_exists('pfp_log')) {
        pfp_log('[PFP] No PDF generator available for invoice.', 'warning');
    } else {
        bypf_log('[PFP] No PDF generator available for invoice.', 'warning');
    }
    return '';
}
