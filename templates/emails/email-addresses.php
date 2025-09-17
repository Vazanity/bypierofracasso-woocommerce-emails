<?php
/**
 * Email Addresses
 *
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 8.6.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$text_align = is_rtl() ? 'right' : 'left';
$address    = ($order instanceof WC_Order) ? $order->get_formatted_billing_address() : __('No billing address available', 'bypierofracasso-woocommerce-emails');
$shipping   = ($order instanceof WC_Order) ? $order->get_formatted_shipping_address() : '';

$before = '';
$after  = '';
?>

<!-- Contents : Order Info | Order Name | Order Date -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <!-- 520 -->
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                                        <tr>
                                            <td class="spacer-15"> </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle">
                                                <!--[if (gte mso 9)|(IE)]><table border="0" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
                                                <!-- Columns 1 OF 2 -->
                                                <table width="250" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-250 table-left">
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-600 font-space-0">
                                                            <?php
                                                            echo wp_kses_post($before . sprintf(__('Order Number : ', 'bypierofracasso-woocommerce-emails') . $after . '<br><span class="font-primary font-595959 font-16 font-weight-400 font-space-0"> #%s</span>', ($order instanceof WC_Order) ? $order->get_order_number() : 'N/A'));
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                <!-- Columns 20px Gaps -->
                                                <table width="20" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-20 table-left">
                                                    <tr>
                                                        <td valign="middle" align="center" height="20"></td>
                                                    </tr>
                                                </table>
                                                <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                <!-- Columns 2 OF 2 -->
                                                <table width="250" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-250 table-left">
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-600 font-space-0">
                                                            <?php
                                                            echo wp_kses_post($before . sprintf(__('Order Date : ', 'bypierofracasso-woocommerce-emails') . $after . '<br><span class="font-primary font-595959 font-16 font-weight-400 font-space-0 capitalize"><time datetime="%s">%s</time></span>', ($order instanceof WC_Order) ? $order->get_date_created()->format('c') : 'N/A', ($order instanceof WC_Order) ? wc_format_datetime($order->get_date_created()) : 'N/A'));
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-15"> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- End 520 -->
                    </td>
                </tr>
            </table>
            <!-- End 600 -->
        </td>
    </tr>
</table>
<!-- Contents : Order Info | Order Name | Order Date -->

<!-- Dividers : Divider -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <!-- 520 -->
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
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
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- End 520 -->
                    </td>
                </tr>
            </table>
            <!-- End 600 -->
        </td>
    </tr>
</table>
<!-- Dividers : Divider -->

<!-- Contents : Payment Info | Payment Status | Payment Method -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <!-- 520 -->
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                                        <tr>
                                            <td class="spacer-15"> </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle">
                                                <!--[if (gte mso 9)|(IE)]><table border="0" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
                                                <!-- Columns 1 OF 2 -->
                                                <table width="250" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-250 table-left">
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-600 font-space-0">
                                                            <?php echo wp_kses_post($before . sprintf(__('Payment Status : ', 'bypierofracasso-woocommerce-emails'))); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" valign="middle">
                                                            <table border="0" align="left" cellpadding="0" cellspacing="0" class="center-float">
                                                                <?php if ($order instanceof WC_Order && in_array($order->get_status(), ['completed', 'active'])) : ?>
                                                                <tr>
                                                                    <td align="left" valign="middle" class="bg-D1F3E6 font-18C184 font-primary font-16 font-weight-400 font-space-0 border-radius plr-10 capitalize">
                                                                        <?php echo $order->get_status(); ?>
                                                                    </td>
                                                                </tr>
                                                                <?php endif; ?>
                                                                <?php if ($order instanceof WC_Order && in_array($order->get_status(), ['pending', 'on-hold', 'processing'])) : ?>
                                                                <tr>
                                                                    <td align="left" valign="middle" class="bg-FFF6D6 font-FED330 font-primary font-16 font-weight-400 font-space-0 border-radius plr-10 capitalize">
                                                                        <?php echo $order->get_status(); ?>
                                                                    </td>
                                                                </tr>
                                                                <?php endif; ?>
                                                                <?php if ($order instanceof WC_Order && in_array($order->get_status(), ['cancelled', 'failed', 'refunded', 'expired'])) : ?>
                                                                <tr>
                                                                    <td align="left" valign="middle" class="bg-FEDEE0 font-FC5C65 font-primary font-16 font-weight-400 font-space-0 border-radius plr-10 capitalize">
                                                                        <?php echo $order->get_status(); ?>
                                                                    </td>
                                                                </tr>
                                                                <?php endif; ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                <!-- Columns 20px Gaps -->
                                                <table width="20" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-20 table-left">
                                                    <tr>
                                                        <td valign="middle" align="center" height="20"></td>
                                                    </tr>
                                                </table>
                                                <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                <!-- Columns 2 OF 2 -->
                                                <table width="250" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-250 table-left">
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-600 font-space-0">
                                                            <?php
                                                            $payment_method_display = ($order instanceof WC_Order) ? $order->get_payment_method_title() : 'N/A';
                                                            echo wp_kses_post($before . sprintf(__('Payment Method : ', 'bypierofracasso-woocommerce-emails') . $after . '<br><span class="font-primary font-595959 font-16 font-weight-400 font-space-0 uppercase">' . $payment_method_display . '</span>'));
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-15"> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- End 520 -->
                    </td>
                </tr>
            </table>
            <!-- End 600 -->
        </td>
    </tr>
</table>
<!-- Contents : Payment Info | Payment Status | Payment Method -->

<!-- Dividers : Divider -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <!-- 520 -->
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
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
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- End 520 -->
                    </td>
                </tr>
            </table>
            <!-- End 600 -->
        </td>
    </tr>
</table>
<!-- Dividers : Divider -->

<!-- Contents : Payment Info -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <!-- 520 -->
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                                        <tr>
                                            <td class="spacer-15"> </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle">
                                                <!--[if (gte mso 9)|(IE)]><table border="0" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
                                                <!-- Columns 1 OF 2 -->
                                                <table width="<?php echo !empty($shipping) ? '250' : '100%'; ?>" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-<?php echo !empty($shipping) ? '250' : '100pc'; ?> table-left">
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-600 font-space-0 pb-5">
                                                            <?php printf(__('Billing Address :', 'bypierofracasso-woocommerce-emails')); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-595959 font-16 font-weight-400 font-space-0" style="word-break:break-word;">
                                                            <?php
                                                            if ($order instanceof WC_Order) {
                                                                echo $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
                                                                if ($order->get_billing_company()) {
                                                                    echo '<br>' . $order->get_billing_company();
                                                                }
                                                                if ($order->get_billing_address_1()) {
                                                                    echo '<br>' . $order->get_billing_address_1() . ' ';
                                                                }
                                                                if ($order->get_billing_address_2()) {
                                                                    echo $order->get_billing_address_2() . ' ';
                                                                }
                                                                if ($order->get_billing_city()) {
                                                                    echo $order->get_billing_city() . ', ' . $order->get_billing_state() . ', ' . $order->get_billing_postcode() . ', ' . $order->get_billing_country() . ' ';
                                                                }
                                                                if ($order->get_billing_phone()) {
                                                                    echo '<br><strong>Phone:</strong> <a href="#" class="font-595959">' . $order->get_billing_phone() . '</a> ';
                                                                }
                                                                if ($order->get_billing_email()) {
                                                                    echo '<strong>Email:</strong> <a href="#" class="font-595959">' . $order->get_billing_email() . '</a> ';
                                                                }
                                                            } else {
                                                                echo __('No billing details available', 'bypierofracasso-woocommerce-emails');
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <?php if (!empty($shipping)) : ?>
                                                <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                <!-- Columns 20px Gaps -->
                                                <table width="20" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-20 table-left">
                                                    <tr>
                                                        <td valign="middle" align="center" height="20"></td>
                                                    </tr>
                                                </table>
                                                <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                <!-- Columns 2 OF 2 -->
                                                <table width="250" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-250 table-left">
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-600 font-space-0 pb-5">
                                                            <?php printf(__('Shipping Address :', 'bypierofracasso-woocommerce-emails')); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-595959 font-16 font-weight-400 font-space-0" style="word-break:break-word;">
                                                            <?php
                                                            if ($order instanceof WC_Order) {
                                                                echo $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name();
                                                                if ($order->get_shipping_company()) {
                                                                    echo '<br>' . $order->get_shipping_company();
                                                                }
                                                                if ($order->get_shipping_address_1()) {
                                                                    echo '<br>' . $order->get_shipping_address_1() . ' ';
                                                                }
                                                                if ($order->get_shipping_address_2()) {
                                                                    echo $order->get_shipping_address_2() . ' ';
                                                                }
                                                                if ($order->get_shipping_city()) {
                                                                    echo $order->get_shipping_city() . ', ' . $order->get_shipping_state() . ', ' . $order->get_shipping_postcode() . ', ' . $order->get_shipping_country() . ' ';
                                                                }
                                                                if ($order->get_shipping_phone()) {
                                                                    echo '<br><strong>Phone:</strong> <a href="#" class="font-595959">' . $order->get_shipping_phone() . '</a> ';
                                                                }
                                                            } else {
                                                                echo __('No shipping details available', 'bypierofracasso-woocommerce-emails');
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <?php endif; ?>
                                                <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-15"> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- End 520 -->
                    </td>
                </tr>
            </table>
            <!-- End 600 -->
        </td>
    </tr>
</table>
<!-- Contents : Payment Info -->

<!-- Dividers : Divider -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <!-- 520 -->
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
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
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- End 520 -->
                    </td>
                </tr>
            </table>
            <!-- End 600 -->
        </td>
    </tr>
</table>
<!-- Dividers : Divider -->
