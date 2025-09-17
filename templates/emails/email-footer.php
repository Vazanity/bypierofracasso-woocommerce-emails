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
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:600px; width:100%;">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <!-- 520 -->
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:520px; width:100%;">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
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
                                                <?php echo __($other_product_title, 'bypierofracasso-woocommerce-emails'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle">
                                                <!--[if (gte mso 9)|(IE)]><table border="0" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
                                                <!-- Columns 1 OF 1 -->
                                                <table width="250" border="0" cellpadding="0" cellspacing="0" align="left" class="row table-250 table-left">
                                                    <tr>
                                                        <td align="center" valign="middle" class="img-responsive pb-15">
                                                            <?php
                                                            $product_1_link = $other_product_1_link ? $other_product_1_link : '#';
                                                            $product_1_alt  = $other_product_1_title ? wp_strip_all_tags($other_product_1_title) : esc_html__('Produktbild', 'bypierofracasso-woocommerce-emails');
                                                            ?>
                                                            <a href="<?php echo esc_url($product_1_link); ?>" style="text-decoration:none;" rel="noopener">
                                                                <img src="<?php echo esc_url($plugin_path . '/' . $other_product_1_img); ?>" alt="<?php echo esc_attr($product_1_alt); ?>" border="0" width="250" class="table-250 border-radius-8" style="display:block; width:100%; max-width:250px; height:auto; border:0;" />
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-400 font-space-0">
                                                            <?php echo __($other_product_1_title, 'bypierofracasso-woocommerce-emails'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-20 font-weight-600 font-space-0">
                                                            <?php echo __($other_product_1_price, 'bypierofracasso-woocommerce-emails'); ?>
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
                                                            <?php
                                                            $product_2_link = $other_product_2_link ? $other_product_2_link : '#';
                                                            $product_2_alt  = $other_product_2_title ? wp_strip_all_tags($other_product_2_title) : esc_html__('Produktbild', 'bypierofracasso-woocommerce-emails');
                                                            ?>
                                                            <a href="<?php echo esc_url($product_2_link); ?>" style="text-decoration:none;" rel="noopener">
                                                                <img src="<?php echo esc_url($plugin_path . '/' . $other_product_2_img); ?>" alt="<?php echo esc_attr($product_2_alt); ?>" border="0" width="250" class="table-250 border-radius-8" style="display:block; width:100%; max-width:250px; height:auto; border:0;" />
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-18 font-weight-400 font-space-0">
                                                            <?php echo __($other_product_2_title, 'bypierofracasso-woocommerce-emails'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="middle" class="center-text font-primary font-191919 font-20 font-weight-600 font-space-0">
                                                            <?php echo __($other_product_2_price, 'bypierofracasso-woocommerce-emails'); ?>
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
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:600px; width:100%;">
                <tr>
                    <td class="spacer-30 hide-mobile">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#FFFFFF" class="bg-FFFFFF">
                        <!-- 100% -->
                        <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
                                    <table border="0" width="570" align="center" cellpadding="0" cellspacing="0" class="row table-570" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:570px; width:100%;">
                                        <tr>
                                            <td class="spacer-15">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="img-responsive">
                                                <a href="<?php echo esc_url($banner_link); ?>" style="text-decoration:none;" rel="noopener">
                                                    <img src="<?php echo esc_url($plugin_path . '/' . $banner_img); ?>" border="0" width="570" alt="" class="block border-radius-8" style="display:block; width:100%; max-width:570px; height:auto; border:0;" />
                                                </a>
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
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
    <tr>
        <td align="center" valign="middle" bgcolor="#F1F1F1" class="bg-F1F1F1">
            <!-- 600 -->
            <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="row table-600" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:600px; width:100%;">
                <tr>
                    <td align="center" bgcolor="#F1F1F1" class="bg-F1F1F1">
                        <!-- 520 -->
                        <table border="0" width="520" align="center" cellpadding="0" cellspacing="0" class="row table-520" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0; max-width:520px; width:100%;">
                            <tr>
                                <td align="center" class="container-padding">
                                    <!-- Content -->
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="center" class="table-100pc" role="presentation" style="border-collapse:collapse; mso-table-lspace:0; mso-table-rspace:0;">
                                        <tr>
                                            <td class="spacer-40">&nbsp;</td>
                                        </tr>
                                        <?php if ($download_app_show == "YES") : ?>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-191919 font-16 font-weight-600 font-space-0 pb-20">
                                                <?php echo __($footer_app_title, 'bypierofracasso-woocommerce-emails'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <?php
                                                        $footer_apps = array(
                                                            array('link' => $footer_app_1_link, 'img' => $footer_app_1_img),
                                                            array('link' => $footer_app_2_link, 'img' => $footer_app_2_img),
                                                            array('link' => $footer_app_3_link, 'img' => $footer_app_3_img),
                                                            array('link' => $footer_app_4_link, 'img' => $footer_app_4_img),
                                                            array('link' => $footer_app_5_link, 'img' => $footer_app_5_img),
                                                        );

                                                        foreach ($footer_apps as $app) {
                                                            if (empty($app['link']) || empty($app['img'])) {
                                                                continue;
                                                            }
                                                            ?>
                                                            <td align="center" width="45">
                                                                <a href="<?php echo esc_url($app['link']); ?>" style="text-decoration:none;" rel="noopener">
                                                                    <img src="<?php echo esc_url($plugin_path . '/' . $app['img']); ?>" alt="" width="35" style="display:block; width:35px; height:auto; border:0;" />
                                                                </a>
                                                            </td>
                                                            <?php
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
                                                <?php echo __($footer_info, 'bypierofracasso-woocommerce-emails'); ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if ($footer_social_title != "") : ?>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-191919 font-16 font-weight-600 font-space-0 pb-20">
                                                <?php echo __($footer_social_title, 'bypierofracasso-woocommerce-emails'); ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td align="center" valign="middle" class="pb-20">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <?php
                                                        $social_links = array(
                                                            array('link' => $social_1_link, 'img' => $social_1_img),
                                                            array('link' => $social_2_link, 'img' => $social_2_img),
                                                            array('link' => $social_3_link, 'img' => $social_3_img),
                                                            array('link' => $social_4_link, 'img' => $social_4_img),
                                                            array('link' => $social_5_link, 'img' => $social_5_img),
                                                        );

                                                        foreach ($social_links as $network) {
                                                            if (empty($network['link']) || empty($network['img'])) {
                                                                continue;
                                                            }
                                                            ?>
                                                            <td align="center" width="45">
                                                                <a href="<?php echo esc_url($network['link']); ?>" style="text-decoration:none;" rel="noopener">
                                                                    <img src="<?php echo esc_url($plugin_path . '/' . $network['img']); ?>" alt="" width="35" style="display:block; width:35px; height:auto; border:0;" />
                                                                </a>
                                                            </td>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="middle" class="font-primary font-999999 font-14 font-weight-400 font-space-0">
                                                <?php
                                                $footer_links = array();

                                                if ($footer_link_1 !== '' && $footer_link_name_1 !== '') {
                                                    $footer_links[] = '<a href="' . esc_url($footer_link_1) . '" class="font-underline font-999999" style="color:#999999; text-decoration:underline;" rel="noopener">' . esc_html($footer_link_name_1) . '</a>';
                                                }
                                                if ($footer_link_2 !== '' && $footer_link_name_2 !== '') {
                                                    $footer_links[] = '<a href="' . esc_url($footer_link_2) . '" class="font-underline font-999999" style="color:#999999; text-decoration:underline;" rel="noopener">' . esc_html($footer_link_name_2) . '</a>';
                                                }
                                                if ($footer_link_3 !== '' && $footer_link_name_3 !== '') {
                                                    $footer_links[] = '<a href="' . esc_url($footer_link_3) . '" class="font-underline font-999999" style="color:#999999; text-decoration:underline;" rel="noopener">' . esc_html($footer_link_name_3) . '</a>';
                                                }
                                                if ($footer_link_4 !== '' && $footer_link_name_4 !== '') {
                                                    $footer_links[] = '<a href="' . esc_url($footer_link_4) . '" class="font-underline font-999999" style="color:#999999; text-decoration:underline;" rel="noopener">' . esc_html($footer_link_name_4) . '</a>';
                                                }

                                                echo wp_kses_post(implode('&nbsp;&nbsp;|&nbsp;&nbsp;', $footer_links));
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

</center>
</body>
</html>
