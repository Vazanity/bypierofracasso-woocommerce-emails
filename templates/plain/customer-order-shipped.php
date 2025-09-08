<?php
/**
 * Plain text version of customer order shipped email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/customer-order-shipped.php.
 *
 * @package WooCommerce/Templates/Emails/Plain
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// E-Mail Header
echo strtoupper(__('Deine Bestellung wurde versendet!', 'piero-fracasso-emails')) . "\n\n";

echo sprintf(__('Hallo %s,', 'piero-fracasso-emails'), $order->get_billing_first_name()) . "\n\n";

echo __('Deine Bestellung ist auf dem Weg und wird in Kürze bei dir eintreffen.', 'piero-fracasso-emails') . "\n\n";

echo sprintf(__('Bestellnummer: %s', 'piero-fracasso-emails'), $order->get_order_number()) . "\n\n";

// Bestell-Link
echo __('Du kannst den Status deiner Bestellung hier einsehen:', 'piero-fracasso-emails') . "\n";
echo esc_url($order->get_view_order_url()) . "\n\n";

// Bestell-Details
echo "--------------------\n";
do_action('woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email);
echo "\n--------------------\n";

do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email);

echo "\n" . __('Vielen Dank für deine Bestellung!', 'piero-fracasso-emails') . "\n";

do_action('woocommerce_email_footer', $email);
?>
