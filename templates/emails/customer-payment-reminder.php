<?php
/**
 * Customer Payment Reminder Email
 */

if (!defined('ABSPATH')) {
    exit;
}

$plugin_path         = plugin_dir_url(__FILE__) . 'images';
include plugin_dir_path(__FILE__) . 'setting-wc-email.php';

$additional_content = isset($additional_content) ? $additional_content : '';

do_action('woocommerce_email_header', $email_heading, $email);
?>

<!-- Titles : Subtitle Title Button -->
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
                                            <td class="spacer-30">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-FFFFFF font-16 font-weight-600 pb-5 font-space-0">
                                                <?php echo esc_html($pending_order_subtitle); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-FFFFFF font-36 font-weight-400 font-space-0 pb-30">
                                                <?php echo esc_html($email_heading); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center" class="bg-FFFFFF block btn border-radius-4">
                                                            <a href="<?php echo ($order instanceof WC_Order) ? esc_url($order->get_view_order_url()) : '#'; ?>" class="font-primary font-4B7BEC font-14 font-weight-600 font-space-0-5 block btn white-space">
                                                                <?php echo esc_html($pending_order_btn); ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-15">&nbsp;</td>
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
                                                <img src="<?php echo esc_url($plugin_path . '/' . $pending_order_hero_bg_img); ?>" border="0" width="600" alt="Header" class="block table-600">
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
                                            <td class="spacer-30">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-600 font-space-0 pb-20">
                                                <?php
                                                if ($order instanceof WC_Order) {
                                                    echo esc_html(sprintf(
                                                        /* translators: %s: customer first name */
                                                        __('Hallo %s,', 'bypierofracasso-woocommerce-emails'),
                                                        $order->get_billing_first_name()
                                                    ));
                                                } else {
                                                    echo esc_html__('Hallo,', 'bypierofracasso-woocommerce-emails');
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" class="center-text font-primary font-595959 font-16 font-weight-400 font-space-0 pb-20" style="padding:0px;">
                                                <p style="margin:0 0 10px;">
                                                    <?php echo esc_html__('Dies ist eine Zahlungserinnerung zu Ihrer Bestellung. Die Rechnung finden Sie im Anhang.', 'bypierofracasso-woocommerce-emails'); ?>
                                                </p>
                                                <?php if (!empty($additional_content)) : ?>
                                                    <p style="margin:0 0 10px;">
                                                        <?php echo wp_kses_post(wptexturize($additional_content)); ?>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if ($order instanceof WC_Order && $order->get_customer_note() !== '') : ?>
                                                    <p style="margin:10px 0 0;">
                                                        <strong><?php echo esc_html__('Hinweis:', 'bypierofracasso-woocommerce-emails'); ?></strong>
                                                        <?php echo wp_kses_post($order->get_customer_note()); ?>
                                                    </p>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-15">&nbsp;</td>
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
                                            <td class="spacer-15">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-F1F1F1 spacer-1">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-15">&nbsp;</td>
                                        </tr>
                                        <?php if ($order instanceof WC_Order) : ?>
                                            <?php
                                            do_action('woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email);
                                            do_action('woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email);
                                            do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email);
                                            ?>
                                        <?php else : ?>
                                            <tr>
                                                <td align="left" class="font-primary font-595959 font-16 font-weight-400">
                                                    <?php echo esc_html__('[Bestelldetails folgen]', 'bypierofracasso-woocommerce-emails'); ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td class="spacer-15">&nbsp;</td>
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
/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */

do_action('woocommerce_email_footer', $email);
