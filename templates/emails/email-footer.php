<?php
/**
 * Email Footer
 *
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 9.6.0
 */

defined('ABSPATH') || exit;

// ******************************//
//            Don't Touch
// ******************************//
$plugin_path = plugin_dir_url(__FILE__) . 'images'; // Image Path

// *************************************//
//            Starto Setting File
// *************************************//

include('setting-wc-email.php'); // All Customization in This File

?>

<?php if ($other_product_show == "YES") : ?>
<!-- Products : Other Products -->
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
                                            <td class="spacer-15">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-F1F1F1 spacer-1">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-30">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td valign="middle" class="center-text font-primary font-191919 font-20 font-weight-600 font-space-0 pb-30">
                                                <?php echo __($other_product_title); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle">
                                                <!--[if (gte mso 9)|(IE)]><table border="0" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
                                                <!-- Columns 1 OF 1 -->
                                                <table width="250" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-250 table-left">
                                                    <tr>
                                                        <td align="center" valign="middle" class="img-responsive pb-15">
                                                            <?php echo __('<a href="' . $other_product_1_link . '"><img src="' . esc_url($plugin_path . '/' . $other_product_1_img) . '" alt="Product 1" border="0" width="250" class="table-250 border-radius-8"></a>'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-400 font-space-0">
                                                            <?php echo __($other_product_1_title); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-20 font-weight-600 font-space-0">
                                                            <?php echo __($other_product_1_price); ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                <!-- Columns 20px Gaps -->
                                                <table width="20" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-20 table-left">
                                                    <tr>
                                                        <td valign="middle" align="center" height="30"></td>
                                                    </tr>
                                                </table>
                                                <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                                                <!-- Columns 2 OF 2 -->
                                                <table width="250" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-250 table-left">
                                                    <tr>
                                                        <td align="center" valign="middle" class="img-responsive pb-15">
                                                            <?php echo __('<a href="' . $other_product_2_link . '"><img src="' . esc_url($plugin_path . '/' . $other_product_2_img) . '" alt="Product 2" border="0" width="250" class="table-250 border-radius-8"></a>'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-400 font-space-0">
                                                            <?php echo __($other_product_2_title); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-20 font-weight-600 font-space-0">
                                                            <?php echo __($other_product_2_price); ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-30">&nbsp;</td>
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
<!-- Products : Other Products -->
<?php endif; ?>

<?php if ($banner_show == "YES" && $banner_link != "" && $banner_img != "") : ?>
<!-- Banner : Full Image -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td class="spacer-30 hide-mobile">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <!-- 100% -->
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
                                    <table border="0" width="570" align="center" cellpadding="0" cellspacing="0" class="row table-570">
                                        <tr>
                                            <td class="spacer-15">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="img-responsive">
                                                <?php echo __('<a href="' . $banner_link . '"><img src="' . esc_url($plugin_path . '/' . $banner_img) . '" border="0" width="570" alt="Banner" class="block border-radius-8" style="width:570px; max-width:570px;"></a>'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-15">&nbsp;</td>
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
<!-- Banner : Full Image -->
<?php endif; ?>

<!-- Footers : -->
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600">
                <tr>
                    <td align="center" bgcolor="#F1F1F1" class="bg-F1F1F1">
                        <!-- 520 -->
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc">
                                        <tr>
                                            <td class="spacer-40">&nbsp;</td>
                                        </tr>
                                        <?php if ($download_app_show == "YES") : ?>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-191919 font-16 font-weight-600 font-space-0 pb-20">
                                                <?php echo __($footer_app_title); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <?php
                                                        if ($footer_app_1_link != "") {
                                                            echo __('<td align="center" width="45"><a href="' . $footer_app_1_link . '"><img src="' . esc_url($plugin_path . '/' . $footer_app_1_img) . '" alt="Social" width="35" style="width:35px;"></a></td>');
                                                        }
                                                        if ($footer_app_2_link != "") {
                                                            echo __('<td align="center" width="45"><a href="' . $footer_app_2_link . '"><img src="' . esc_url($plugin_path . '/' . $footer_app_2_img) . '" alt="Social" width="35" style="width:35px;"></a></td>');
                                                        }
                                                        if ($footer_app_3_link != "") {
                                                            echo __('<td align="center" width="45"><a href="' . $footer_app_3_link . '"><img src="' . esc_url($plugin_path . '/' . $footer_app_3_img) . '" alt="Social" width="35" style="width:35px;"></a></td>');
                                                        }
                                                        if ($footer_app_4_link != "") {
                                                            echo __('<td align="center" width="45"><a href="' . $footer_app_4_link . '"><img src="' . esc_url($plugin_path . '/' . $footer_app_4_img) . '" alt="Social" width="35" style="width:35px;"></a></td>');
                                                        }
                                                        if ($footer_app_5_link != "") {
                                                            echo __('<td align="center" width="45"><a href="' . $footer_app_5_link . '"><img src="' . esc_url($plugin_path . '/' . $footer_app_5_img) . '" alt="Social" width="35" style="width:35px;"></a></td>');
                                                        }
                                                        ?>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="middle" align="center" height="20"></td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if ($footer_info != "") : ?>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-999999 font-14 font-weight-400 font-space-0 pb-20">
                                                <?php echo __($footer_info); ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if ($footer_social_title != "") : ?>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-191919 font-16 font-weight-600 font-space-0 pb-20">
                                                <?php echo __($footer_social_title); ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td align="center" valign="middle" class="pb-20">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <?php
                                                        if ($social_1_link != "") {
                                                            echo __('<td align="center" width="45"><a href="' . $social_1_link . '"><img src="' . esc_url($plugin_path . '/' . $social_1_img) . '" alt="Social" width="35" style="width:35px;"></a></td>');
                                                        }
                                                        if ($social_2_link != "") {
                                                            echo __('<td align="center" width="45"><a href="' . $social_2_link . '"><img src="' . esc_url($plugin_path . '/' . $social_2_img) . '" alt="Social" width="35" style="width:35px;"></a></td>');
                                                        }
                                                        if ($social_3_link != "") {
                                                            echo __('<td align="center" width="45"><a href="' . $social_3_link . '"><img src="' . esc_url($plugin_path . '/' . $social_3_img) . '" alt="Social" width="35" style="width:35px;"></a></td>');
                                                        }
                                                        if ($social_4_link != "") {
                                                            echo __('<td align="center" width="45"><a href="' . $social_4_link . '"><img src="' . esc_url($plugin_path . '/' . $social_4_img) . '" alt="Social" width="35" style="width:35px;"></a></td>');
                                                        }
                                                        if ($social_5_link != "") {
                                                            echo __('<td align="center" width="45"><a href="' . $social_5_link . '"><img src="' . esc_url($plugin_path . '/' . $social_5_img) . '" alt="Social" width="35" style="width:35px;"></a></td>');
                                                        }
                                                        ?>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-999999 font-14 font-weight-400 font-space-0">
                                                <?php
                                                if ($footer_link_1 != "") {
                                                    echo __('<a href="' . $footer_link_1 . '" class="font-underline font-999999">' . $footer_link_name_1 . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;');
                                                }
                                                if ($footer_link_2 != "") {
                                                    echo __('<a href="' . $footer_link_2 . '" class="font-underline font-999999">' . $footer_link_name_2 . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;');
                                                }
                                                if ($footer_link_3 != "") {
                                                    echo __('<a href="' . $footer_link_3 . '" class="font-underline font-999999">' . $footer_link_name_3 . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;');
                                                }
                                                if ($footer_link_4 != "") {
                                                    echo __('<a href="' . $footer_link_4 . '" class="font-underline font-999999">' . $footer_link_name_4 . '</a>');
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-40">&nbsp;</td>
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
<!-- Footers : -->
