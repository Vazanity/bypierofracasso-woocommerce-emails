<?php
/**
 * Customer Order Shipped Email
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
include('setting-wc-email.php');

do_action('woocommerce_email_header', $email_heading, $email);
?>

<!-- Titles : Subtitle Title -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#4B7BEC" class="bg-4B7BEC">
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
                            <tr>
                                <td align="center" class="container-padding">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                                        <tr>
                                            <td class="spacer-30"> </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-FFFFFF font-16 font-weight-600 pb-5 font-space-0">
                                                <?php echo __($shipped_order_subtitle); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-FFFFFF font-36 font-weight-400 font-space-0 pb-30">
                                                <?php echo __($email_heading); ?>
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
<!-- Titles : Subtitle Title -->

<!-- Headers : Full Image -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#4B7BEC" class="bg-4B7BEC">
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                            <tr>
                                <td align="center">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                                        <tr>
                                            <td align="center" valign="middle" class="img-responsive">
                                                <img src="<?php echo esc_url($plugin_path . '/' . $shipped_order_hero_bg_img); ?>" border="0" width="600" alt="Header" class="block table-600">
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
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
                            <tr>
                                <td align="center" class="container-padding">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                                        <tr>
                                            <td class="spacer-30"> </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-600 font-space-0 pb-20">
                                                <?php
                                                if ($order instanceof WC_Order) {
                                                    echo __($shipped_order_greeting . " " . esc_html($order->get_billing_first_name()) . ',');
                                                } else {
                                                    echo __($shipped_order_greeting . " Customer,");
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" class="center-text font-primary font-595959 font-16 font-weight-400 font-space-0 pb-20" style="padding:0px;">
                                                <?php
                                                echo __($shipped_order_message);
                                                if (isset($additional_content) && $additional_content) {
                                                    echo '<br><br>' . wp_kses_post(wptexturize($additional_content));
                                                }
                                                if ($order instanceof WC_Order && $order->get_customer_note() != "") {
                                                    echo __('<br><br> <strong>Note</strong>: ', 'piero-fracasso-emails');
                                                    echo wp_kses_post($order->get_customer_note());
                                                }
                                                ?>
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
<!-- Contents : Title Description -->

<!-- Dividers : Divider -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
                            <tr>
                                <td align="center" class="container-padding">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
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
                                                    <?php echo __('[Order Details Placeholder]', 'piero-fracasso-emails'); ?>
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
<!-- Dividers : Divider -->

<?php
do_action('woocommerce_email_footer', $email);
?>
