<?php
/**
 * Customer New Account Email
 *
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

// ************************************//
//                Don't Touch
// ************************************//

$plugin_path = plugin_dir_url(__FILE__) . 'images'; // Image Path

// *************************************//
//             Starto Setting File
// *************************************//

include('setting-wc-email.php'); // All Customization in This File

do_action('woocommerce_email_header', $email_heading, $email);
?>

<!-- Titles : Subtitle Title Button -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#4B7BEC" class="bg-4B7BEC">
                        <!-- 520 -->
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                                        <tr>
                                            <td class="spacer-30"> </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-FFFFFF font-16 font-weight-600 pb-5 font-space-0">
                                                <?php echo __($new_account_subtitle); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-FFFFFF font-36 font-weight-400 font-space-0">
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
                        <!-- End 520 -->
                    </td>
                </tr>
            </table>
            <!-- End 600 -->
        </td>
    </tr>
</table>
<!-- Titles : Subtitle Title Button -->

<!-- Headers : Full Image -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#4B7BEC" class="bg-4B7BEC">
                        <!-- 100% -->
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                            <tr>
                                <td align="center">
                                    <!-- Content -->
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                                        <tr>
                                            <td align="center" valign="middle" class="img-responsive">
                                                <img src="<?php echo esc_url($plugin_path . '/' . $new_account_hero_bg_img); ?>" border="0" width="600" alt="Header" class="block table-600">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- 100% -->
                    </td>
                </tr>
            </table>
            <!-- End 600 -->
        </td>
    </tr>
</table>
<!-- Header : Full Image -->

<!-- Contents : Title Description Button -->
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
                                            <td class="spacer-30"> </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" class="font-primary font-191919 font-18 font-weight-600 font-space-0 pb-20">
                                                <?php
                                                if (isset($email->user_firstname) && !empty($email->user_firstname)) {
                                                    echo __($new_account_greeting . " " . esc_html($email->user_firstname) . ',');
                                                } elseif (!empty($email->user_login)) {
                                                    echo __($new_account_greeting . " " . esc_html($email->user_login) . ',');
                                                } else {
                                                    echo __($new_account_greeting . " Customer,");
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" class="font-primary font-595959 font-16 font-weight-400 font-space-0 pb-20">
                                                <?php printf(esc_html__('Thanks for creating an account on %1$s. Your username is %2$s. You can access your account here', 'piero-fracasso-emails'), esc_html($blogname), '<strong>' . esc_html($email->user_login) . '</strong>'); ?>
                                            </td>
                                        </tr>
                                        <?php if ('yes' === get_option('woocommerce_registration_generate_password') && $email->password_generated): ?>
                                            <tr>
                                                <td align="left" valign="middle" class="font-primary font-595959 font-16 font-weight-400 font-space-0 pb-20">
                                                    <?php printf(__('Your password has been automatically generated: %s', 'piero-fracasso-emails'), '<strong>' . esc_html($email->user_pass) . '</strong>'); ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td align="left" valign="middle" class="font-primary font-595959 font-16 font-weight-400 font-space-0 pb-40">
                                                <?php printf(__('Or you can verify using this Link: <br> <a style="color:#4B7BEC;" href="%s">%s</a>', 'piero-fracasso-emails'), esc_url(wc_get_page_permalink('myaccount')), esc_url(wc_get_page_permalink('myaccount'))); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center" class="bg-4B7BEC block btn border-radius-4">
                                                            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="font-primary font-FFFFFF font-14 font-weight-600 font-space-0-5 block btn white-space">
                                                                <?php echo __($new_account_btn, 'piero-fracasso-emails'); ?>
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
                        <!-- End 520 -->
                    </td>
                </tr>
            </table>
            <!-- End 600 -->
        </td>
    </tr>
</table>
<!-- Contents : Title Description Button -->

<?php if ($new_account_regards_show == "YES"): ?>
<!-- Regards : Text -->
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
                                            <td class="spacer-30"> </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" class="font-primary font-191919 font-18 font-weight-600 font-space-0">
                                                <?php echo __($new_account_regards_1); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" class="font-primary font-595959 font-16 font-weight-400 font-space-0">
                                                <?php echo __($new_account_regards_2); ?>
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
<!-- Regards : Text -->
<?php endif; ?>

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

<!-- Contents : Title Description Button -->
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
                                            <td align="left" valign="middle" class="font-primary font-595959 font-16 font-weight-400 font-space-0">
                                                <?php echo __($new_account_description); ?>
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
<!-- Contents : Title Description Button -->

<?php do_action('woocommerce_email_footer', $email); ?>
