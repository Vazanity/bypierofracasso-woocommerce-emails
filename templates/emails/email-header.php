<?php
/**
 * Email Header
 *
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 4.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// ******************************//
//            Don't Touch
// ******************************//
$plugin_path = plugin_dir_url(__FILE__) . 'images'; // Image Path

// *************************************//
//             Starto Setting File
// *************************************//

include('setting-wc-email.php'); // All Customization in This File

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" <?php language_attributes(); ?>>
<head>
    <!--[if (gte mso 9)|(IE)]>
        <xml>
            <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="date=no">
    <meta name="format-detection" content="address=no">
    <meta name="format-detection" content="email=no">
    <title><?php echo get_bloginfo('name', 'display'); ?></title>

    <!-- Google Fonts Link -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">

</head>

<body marginwidth="0" topmargin="0" marginheight="0" offset="0">
<center>

<?php if ($top_offer_show == "YES") : ?>
<!-- Top bars : Offer Link -->
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
                                            <td class="spacer-10"> </td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="middle" class="center-text font-primary font-12 font-weight-400 font-normal font-999999 text-decoration-none font-space-0">
                                                <?php echo __('<a class="font-999999 font-underline" href="' . $top_offer_link . '">' . $top_offer_text . '</a>'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="spacer-10"> </td>
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
<!-- Top Bars : Offer Link -->
<?php endif; ?>

<!-- Navigation : Center Logo -->
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
                                            <td class="spacer-60"> </td>
                                        </tr>
                                        <tr>
                                            <?php
                                            if ($img = get_option('woocommerce_email_header_image')) {
                                                echo __('<td align="center"><a href="' . get_home_url() . '"><img src="' . esc_url($img) . '" alt="' . get_bloginfo('name', 'display') . '" width="300px" style="width:' . $logoWidth . ';" class="block" /></a></td>');
                                            } else {
                                                echo __('<td align="center" class="font-FFFFFF font-primary font-36 font-weight-600"><a class="font-FFFFFF" href="' . get_home_url() . '">' . get_bloginfo('name', 'display') . '</a></td>');
                                            }
                                            ?>
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
<!-- Navigation : Center Logo -->
