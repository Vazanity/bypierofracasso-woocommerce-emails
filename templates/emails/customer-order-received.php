<?php
/**
 * Customer Order Received Email
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_email_header', $email_heading, $email);
?>

<?php if (isset($order) && $order instanceof WC_Order && $order->get_payment_method() === 'pfp_invoice') : ?>
    <p style="margin:0 0 16px;">
        <?php echo esc_html__('Vielen Dank für Ihre Bestellung. Sie haben Zahlung per Rechnung gewählt. Die Rechnung liegt dieser E-Mail als PDF bei. Zahlungsfrist: 10 Tage.', 'bypierofracasso-woocommerce-emails'); ?>
    </p>
<?php else : ?>
    <p style="margin:0 0 16px;">
        <?php echo esc_html__('Vielen Dank für Ihre Bestellung. Wir haben Ihre Bestellung erhalten und bearbeiten sie umgehend.', 'bypierofracasso-woocommerce-emails'); ?>
    </p>
<?php endif; ?>

<?php
if (isset($order) && $order instanceof WC_Order) {
    do_action('woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email);
    do_action('woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email);
    do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email);
}

do_action('woocommerce_email_footer', $email);
