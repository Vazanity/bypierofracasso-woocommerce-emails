<?php
/**
 * Customer Order Received Email
 *
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$plugin_path = plugin_dir_url(__FILE__) . 'images';
include(plugin_dir_path(__FILE__) . 'setting-wc-email.php');

do_action('woocommerce_email_header', $email_heading, $email);
?>

<!-- Titles : Subtitle Title Button -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:600px; width:100%;">
                <tr>
                    <td align="center" bgcolor="#4B7BEC" class="bg-4B7BEC">
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:520px; width:100%;">
                            <tr>
                                <td align="center" class="container-padding">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
                                        <tr>
                                            <td class="spacer-30"> </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-FFFFFF font-16 font-weight-600 pb-5 font-space-0">
                                                <?php echo __($order_received_subtitle, 'bypierofracasso-woocommerce-emails'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-FFFFFF font-36 font-weight-400 font-space-0 pb-30">
                                                <?php echo __($email_heading, 'bypierofracasso-woocommerce-emails'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center" class="bg-FFFFFF block btn border-radius-4">
                                                            <a href="<?php echo ($order instanceof WC_Order) ? esc_url($order->get_view_order_url()) : '#'; ?>" class="font-primary font-4B7BEC font-14 font-weight-600 font-space-0-5 block btn white-space" style="display:inline-block; padding:12px 28px; background-color:#FFFFFF; color:#4B7BEC; text-decoration:none; border-radius:4px; line-height:1.4; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;">
                                                                <?php echo __($order_received_btn, 'bypierofracasso-woocommerce-emails'); ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-15"> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- Titles : Subtitle Title Button -->

<!-- Headers : Full Image -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:600px; width:100%;">
                <tr>
                    <td align="center" bgcolor="#4B7BEC" class="bg-4B7BEC">
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
                            <tr>
                                <td align="center">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
                                        <tr>
                                            <td align="center" valign="middle" class="img-responsive">
                                                <img src="<?php echo esc_url($plugin_path . '/' . $order_received_hero_bg_img); ?>" border="0" width="600" alt="" class="block table-600" style="display:block; width:100%; height:auto; border:0;">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- Header : Full Image -->

<!-- Contents : Title Description -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:600px; width:100%;">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:520px; width:100%;">
                            <tr>
                                <td align="center" class="container-padding">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
                                        <tr>
                                            <td class="spacer-30"> </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-600 font-space-0 pb-20">
                                                <?php
                                                if ($order instanceof WC_Order) {
                                                    echo __($order_received_greeting . " " . esc_html($order->get_billing_first_name()) . ',', 'bypierofracasso-woocommerce-emails');
                                                } else {
                                                    echo __($order_received_greeting . " Customer,", 'bypierofracasso-woocommerce-emails');
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" class="center-text font-primary font-595959 font-16 font-weight-400 font-space-0 pb-20" style="padding:0px;">
                                                <?php
                                                echo __($order_received_message, 'bypierofracasso-woocommerce-emails');
                                                if (isset($additional_content) && $additional_content) {
                                                    echo '<br><br>' . wp_kses_post(wptexturize($additional_content));
                                                }
                                                if ($order instanceof WC_Order && $order->get_customer_note() != "") {
                                                    echo __('<br><br> <strong>Note</strong>: ', 'bypierofracasso-woocommerce-emails');
                                                    echo wp_kses_post($order->get_customer_note());
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php if (isset($order) && $order instanceof WC_Order && 'pfp_invoice' === $order->get_payment_method()) : ?>
                                        <tr>
                                            <td>
                                                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
                                                    <tr>
                                                        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
                                                            <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:520px; width:100%;">
                                                                <tr>
                                                                    <td align="left" class="container-padding center-text font-primary font-191919 font-16 font-weight-400 font-space-0" style="background:#F7F7F7; padding:12px 16px; border-radius:4px;">
                                                                        <strong><?php echo esc_html__('Die Rechnung finden Sie im Anhang dieser Bestellbestätigung.', 'bypierofracasso-woocommerce-emails'); ?></strong>
                                                                        <div style="margin-top:6px;">
                                                                            <?php echo esc_html__('Rechnungsbetrag sofort zahlbar nach Erhalt.', 'bypierofracasso-woocommerce-emails'); ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr><td class="spacer-15">&nbsp;</td></tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td class="spacer-15"> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- Contents : Title Description -->

<!-- Dividers : Divider -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:600px; width:100%;">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:520px; width:100%;">
                            <tr>
                                <td align="center" class="container-padding">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
                                        <tr>
                                            <td class="spacer-15"> </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-F1F1F1 spacer-1"> </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-15"> </td>
                                        </tr>
                                            <?php if ($order instanceof WC_Order) : ?>
                                                <?php
                                                do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email);
                                                do_action('woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email);
                                                do_action('woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email);
                                                ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td align="left" class="font-primary font-595959 font-16 font-weight-400">
                                                        <?php echo __('[Order Details Placeholder]', 'bypierofracasso-woocommerce-emails'); ?>
                                                    </td>
                                                </tr>
                                            </table>

                                        <?php endif; ?>
                                        <tr>
                                            <td class="spacer-15"> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- Dividers : Divider -->

<!-- Buttons : Button -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:600px; width:100%;">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:520px; width:100%;">
                            <tr>
                                <td align="center" class="container-padding">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
                                        <tr>
                                            <td class="spacer-20"> </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center" class="bg-4B7BEC block btn border-radius-4">
                                                            <a href="<?php echo ($order instanceof WC_Order) ? esc_url($order->get_view_order_url()) : '#'; ?>" class="font-primary font-FFFFFF font-14 font-weight-600 font-space-0-5 block btn white-space" style="display:inline-block; padding:12px 28px; background-color:#4B7BEC; color:#FFFFFF; text-decoration:none; border-radius:4px; line-height:1.4; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;">
                                                                <?php echo __($order_received_btn, 'bypierofracasso-woocommerce-emails'); ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-30"> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- Buttons : Button -->

<?php
do_action('woocommerce_email_footer', $email);
?>
