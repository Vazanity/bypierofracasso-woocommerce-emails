<?php
/**
 * Email Styles
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load colors.
$bg        = get_option( 'woocommerce_email_background_color' );
$body      = get_option( 'woocommerce_email_body_background_color' );
$base      = get_option( 'woocommerce_email_base_color' );
$base_text = wc_light_or_dark( $base, '#191919', '#ffffff' );
$text      = get_option( 'woocommerce_email_text_color' );

// Pick a contrasting color for links.
$link_color = wc_hex_is_light( $base ) ? $base : $base_text;

// Pick a contrasting color for Btn.
$btn_color = wc_hex_is_light( $base ) ? $base : $base_text;

if ( wc_hex_is_light( $body ) ) {
	$link_color = wc_hex_is_light( $base ) ? $base_text : $base;
}

$text_lighter_31	= wc_hex_lighter( $text, 31 );
$text_lighter_63	= wc_hex_lighter( $text, 63 );

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
// body{padding: 0;} ensures proper scale/positioning of the email in the iOS native email app.

?>


body {
	margin: 0px !important;
	padding: 0px !important;
	display: block !important;
	min-width: 100% !important;
	width: 100% !important;
	-webkit-text-size-adjust: none;
	word-break:break-word;
}

table {
	border-spacing: 0;
	mso-table-lspace: 0pt;
	mso-table-rspace: 0pt;
	text-align:left;
}

table.table-left {
	float: left;
}

table td {
	border-collapse: collapse;
}

strong {
	font-weight: bold !important;
}

td img {
	-ms-interpolation-mode: bicubic;
	display: block;
	width: auto;
	max-width: auto;
	height: auto;
	margin: auto;
	display: block !important;
	border: 0px!important;
}

td p {
	margin: 0 !important;
	padding: 0 !important;
	display: inline-block !important;
	font-family: inherit !important;
}

td a {
	text-decoration: none !important;
	border:0px;
}

a[x-apple-data-detectors] {
	color: inherit !important;
	text-decoration: none !important;
	font-size: inherit !important;
	font-family: inherit !important;
	font-weight: inherit !important;
	line-height: inherit !important;
}

.ExternalClass {
	width: 100%;
	line-height: inherit;
}

.ReadMsgBody {
	width:100%;
	background-color: #ffffff;
}


.font-primary {
	font-family: 'Poppins', Helvetica, Trebuchet MS, Verdana, sans-serif;
}


.table-100pc {
	width: 100%;
	max-width: 100%;
	margin: 0 auto;
}

.table-10 {
	width: 10px;
	max-width: 10px;
	margin: 0 auto;
}

.table-20 {
	width: 20px;
	max-width: 20px;
	margin: 0 auto;
}

.table-90 {
	width: 90px;
	max-width: 90px;
	margin: 0 auto;
}

.table-100 {
	width:100px;
	max-width:100px;
}

.table-250 {
	width: 250px;
	max-width: 250px;
	margin: 0 auto;
}

.table-255 {
	width: 255px;
	max-width: 255px;
	margin: 0 auto;
}

.table-300 {
	width: 300px;
	max-width: 300px;
	margin: 0 auto;
}

.table-520 {
	width: 520px;
	max-width: 520px;
	margin: 0 auto;
}

.table-570 {
	width: 570px;
	max-width: 570px;
	margin: 0 auto;
}

.table-600 {
	width: 600px;
	max-width: 600px;
	margin: 0 auto;
}



.inline {
	display: inline-block;
}

.block {
	display: block;
}



.bg-F1F1F1 {
	background-color: <?php echo esc_attr( $bg ); ?>;
}

.bg-FFFFFF {
	background-color: <?php echo esc_attr( $body ); ?>;
}

.bg-4B7BEC {
	background-color: <?php echo esc_attr( $base ); ?>;
}

.bg-191919 {
	background-color: <?php echo esc_attr( $text ); ?>;
}

.bg-D1F3E6 {
	background-color: #D1F3E6;
}

.bg-FFF6D6 {
	background-color: #FFF6D6;
}

.bg-FEDEE0 {
	background-color: #FEDEE0;
}



.font-4B7BEC {
	color: <?php echo esc_attr( $base ); ?>;
}

.font-FFFFFF {
	color:#FFFFFF;
}

.font-191919 {
	color: <?php echo esc_attr( $text ); ?>;
}

.font-595959 {
	color: <?php echo esc_attr( $text_lighter_31 ); ?>;
}

.font-999999 {
	color: <?php echo esc_attr( $text_lighter_63 ); ?>;
}

.font-18C184 {
	color:#18C184;
}

.font-FED330 {
	color:#FED330;
}

.font-FC5C65 {
	color:#FC5C65;
}


.font-12 {
	font-size: 12px;
	line-height: 22px;
}

.font-14 {
	font-size: 14px;
	line-height: 24px;
}

.font-16 {
	font-size: 16px;
	line-height: 26px;
}

.font-18 {
	font-size: 18px;
	line-height: 28px;
}

.font-20 {
	font-size: 20px;
	line-height: 30px;
}

.font-22 {
	font-size: 22px;
	line-height: 32px;
}

.font-36 {
	font-size: 36px;
	line-height: 46px;
}



.font-weight-400 {
	font-weight: 400;
}

.font-weight-600 {
	font-weight: 600;
}



.spacer-1 {
	height: 1px;
	font-size: 1px;
	line-height: 1px;
}

.spacer-5 {
	height: 5px;
	font-size: 5px;
	line-height: 5px;
}

.spacer-10 {
	height: 10px;
	font-size: 10px;
	line-height: 10px;
}

.spacer-15 {
	height: 15px;
	font-size: 15px;
	line-height: 15px;
}

.spacer-20 {
	height: 20px;
	font-size: 20px;
	line-height: 20px;
}

.spacer-30 {
	height: 30px;
	font-size: 30px;
	line-height: 30px;
}

.spacer-40 {
	height: 40px;
	font-size: 40px;
	line-height: 40px;
}

.spacer-60 {
	height: 60px;
	font-size: 60px;
	line-height: 60px;
}



.font-normal { 
	font-style:normal;
}

.font-space-0 {
	letter-spacing: 0px;
}

.font-space-0-5 {
	letter-spacing: 0.5px;
}



.text-decoration-none {
	text-decoration:none;
}

.font-underline { 
	text-decoration: underline; 
}



.pb-5 {
	padding: 0;
	padding-bottom: 5px;
}

.pb-15 {
	padding: 0;
	padding-bottom: 15px;
}

.pb-20 {
	padding: 0;
	padding-bottom: 20px;
}

.pb-30 {
	padding: 0;
	padding-bottom: 30px;
}

.pb-40 {
	padding: 0;
	padding-bottom: 40px;
}

.plr-10 {
	padding: 0px 10px;
}

.plr-20 {
	padding: 0px 20px;
}



.border-radius-4 {
	border-radius:4px;
}

.border-radius-8 {
	border-radius:8px;
}



.white-space {
	white-space: nowrap;
}



.btn {
	mso-padding-alt: 16px 60px 16px 60px;
}

.btn a {
	padding: 16px 60px 16px 60px;
	white-space: nowrap;
}

.small small {
	color: <?php echo esc_attr( $text_lighter_63 ); ?>;
	font-size: 12px;
	line-height: 22px;
	font-weight: 600;
	letter-spacing: 0.5px;
}

.small-br small {
	display: block;
}

.uppercase {
	text-transform: uppercase;
}

.capitalize {
	text-transform: capitalize;
}


@media only screen and (max-width:600px) {
	td.img-responsive img {
		width: 100% !important;
		max-width: 100%!important;
		height: auto!important;
		margin: auto;
	}

	table.row {
		width: 100%!important;
		max-width: 100%!important;
	}

	table.center-float,
	td.center-float {
		float: none!important;
	}

	td.center-text {
		text-align: center!important;
	}

	td.container-padding {
		width: 100%!important;
		padding-left: 15px!important;
		padding-right: 15px!important;
	}

	table.hide-mobile,
	tr.hide-mobile,
	td.hide-mobile,
	br.hide-mobile {
		display: none!important;
	}

	td.menu-container {
		text-align: center !important;
	}

	td.autoheight {
		height: auto!important;
	}

	table.mobile-padding {
		margin: 15px 0!important;
	}

	td.br-mobile-none br {
		display: none!important;
	}
}


<?php
