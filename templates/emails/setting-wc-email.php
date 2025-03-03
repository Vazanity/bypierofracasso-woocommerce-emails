<?php
/**
 * Email Styles for byPieroFracasso WooCommerce Emails
 *
 * This file is part of the byPieroFracasso WooCommerce Email Plugin.
 * It defines the styles and custom settings for all email templates used in this plugin.
 *
 * @package  byPieroFracasso - WooCommerce Email Templates
 * @author   byPieroFracasso
 * @version  1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// ********************************************************//
//            Customer Order Completed
// ********************************************************//
$completed_order_subtitle      = __('Your order is complete!', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$completed_order_btn           = __('VIEW ORDER', 'bypierofracasso-woocommerce-emails'); // Button
$completed_order_hero_bg_img   = 'email-header-cust-completed.png'; // Header Image File Name
$completed_order_greeting      = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name
$completed_order_message       = __('Your order at byPieroFracasso is now complete! If you haven’t received it yet, it will be with you shortly. We hope you love your new fragrance! If you have any questions, feel free to reach out.', 'bypierofracasso-woocommerce-emails'); // Custom message

// ***************************************************//
//      Customer Order Received
// ***************************************************//
$order_received_subtitle       = __('We have received your order!', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$order_received_hero_bg_img    = 'email-header-cust-order-received.png'; // Header Image File Name
$order_received_greeting       = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name
$order_received_message        = __('Thank you for your order! We’re preparing it now and will notify you once it ships.', 'woocommerce');
$order_received_btn            = __('VIEW ORDER', 'bypierofracasso-woocommerce-emails'); // Button

// ***************************************************//
//      Customer Order Payment Pending
// ***************************************************//
$pending_order_subtitle        = __('Your payment is pending', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$pending_order_hero_bg_img     = 'email-header-cust-pending-payment.png'; // Header Image File Name
$pending_order_greeting        = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name
$pending_order_btn             = __('PAY NOW', 'bypierofracasso-woocommerce-emails'); // Button

// ***************************************************//
//      Customer Order Shipped
// ***************************************************//
$shipped_order_subtitle        = __('Your order is on its way!', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$shipped_order_hero_bg_img     = 'email-header-cust-shipped.png'; // Header Image File Name
$shipped_order_greeting        = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name
$shipped_order_message         = __('Your Order is on its way and will arrive soon'); // Email text
//$shipped_order_btn             = __('TRACK ORDER', 'bypierofracasso-woocommerce-emails'); // Button

// ********************************************************//
//            Customer Invoice
// ********************************************************//
$invoice_subtitle              = __('Your Invoice for Your Order at byPieroFracasso', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$invoice_hero_bg_img           = 'email-header-cust-invoice.png'; // Header Image File Name
$invoice_greeting              = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name
$invoice_pending_btn           = __('PAY NOW', 'bypierofracasso-woocommerce-emails'); // Invoice Pending Button Text
$invoice_complete_btn          = __('VIEW ORDER', 'bypierofracasso-woocommerce-emails'); // Invoice Order Complete Button Text

// ***********************************************//
//            Customer New Account
// ***********************************************//
$new_account_subtitle          = __('Before we get started', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$new_account_hero_bg_img       = 'email-header-cust-new-account.png'; // Header Image File Name
$new_account_btn               = __('VERIFY EMAIL', 'bypierofracasso-woocommerce-emails'); // Button
$new_account_greeting          = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name
$new_account_link_text         = __('Or you can confirm email using this Link :', 'bypierofracasso-woocommerce-emails'); // Reset Password Description
$new_account_link              = __('Click here to reset your password', 'bypierofracasso-woocommerce-emails'); // Reset Password Link
$new_account_regards_show      = "NO"; // Team Regards Show 'YES' or 'NO', Case Sensitive
$new_account_regards_1         = __('Thank You,', 'bypierofracasso-woocommerce-emails'); // Regards Thank You Text
$new_account_regards_2         = __('byPieroFracasso', 'bypierofracasso-woocommerce-emails'); // Regards Team Text
$new_account_description       = __('If you didn\'t request to change your password, You don\'t have to do anything.', 'bypierofracasso-woocommerce-emails'); // Reset Password Description

// ********************************************************//
//            Customer Note
// ********************************************************//
$customer_note_subtitle        = __('A note has been added', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$customer_note_btn             = __('VIEW ORDER', 'bypierofracasso-woocommerce-emails'); // Button
$customer_note_hero_bg_img     = 'email-header-cust-note.png'; // Header Image File Name
$customer_note_greeting        = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name

// ********************************************************//
//            Customer on-Hold Order
// ********************************************************//
$on_hold_order_subtitle        = __('Until payment is received', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$on_hold_order_btn             = __('MANAGE ORDER', 'bypierofracasso-woocommerce-emails'); // Button
$on_hold_order_hero_bg_img     = 'email-header-cust-on-hold.png'; // Header Image File Name
$on_hold_order_greeting        = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name

// ********************************************************//
//            Customer Processing Order
// ********************************************************//
$processing_order_subtitle     = __('Your order is currently being processed. We will notify you as soon as it has been shipped.', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$processing_order_btn          = __('VIEW ORDER', 'bypierofracasso-woocommerce-emails'); // Button
$processing_order_hero_bg_img  = 'email-header-cust-processing.png'; // Header Image File Name
$processing_order_greeting     = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name

// ***********************************************//
//            Customer Refunded Order
// ***********************************************//
$refunded_order_subtitle       = __('Your order refund status', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$refunded_order_btn            = __('VIEW ORDER', 'bypierofracasso-woocommerce-emails'); // Button
$refunded_order_hero_bg_img    = 'email-header-cust-refund.png'; // Header Icon Image File Name
$refunded_order_greeting       = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name

// ***********************************************//
//            Customer Reset Password
// ***********************************************//
$reset_password_subtitle       = __('We got a request to', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$reset_password_hero_bg_img    = 'email-header-cust-reset-pw.png'; // Header Icon Image File Name
$reset_password_btn            = __('RESET PASSWORD', 'bypierofracasso-woocommerce-emails'); // Button
$reset_password_greeting       = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name
$reset_password_link_text      = __('Or you can set password using this Link:', 'bypierofracasso-woocommerce-emails'); // Reset Password Description
$reset_password_link           = __('Click here to reset your password', 'bypierofracasso-woocommerce-emails'); // Reset Password Link
$reset_password_regards_show   = "NO"; // Team Regards Show 'YES' or 'NO', Case Sensitive
$reset_password_regards_1      = __('Thank You,', 'bypierofracasso-woocommerce-emails'); // Regards Thank You Text
$reset_password_regards_2      = __('Team Starto', 'bypierofracasso-woocommerce-emails'); // Regards Team Text
$reset_password_description    = __('If you didn\'t request to change your Starto password, You don\'t have to do anything. So that\'s easy', 'bypierofracasso-woocommerce-emails'); // Reset Password Description

// ******************************************************//
//            Admin Cancelled Order
// ******************************************************//
$admin_cancelled_order_subtitle = __('Order has been canceled!', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$admin_cancelled_order_btn      = __('VIEW ORDER', 'bypierofracasso-woocommerce-emails'); // Button
$admin_cancelled_order_hero_bg_img = 'email-header-admin-cancelled.png'; // Header Image File Name
$admin_cancelled_order_greeting = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name

// ******************************************************//
//            Admin Failed Order
// ******************************************************//
$admin_failed_order_subtitle    = __('A customer order has failed. Immediate action may be required.', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$admin_failed_order_btn         = __('VIEW ORDER', 'bypierofracasso-woocommerce-emails'); // Button
$admin_failed_order_hero_bg_img = 'email-header-admin-failed.png'; // Header Image File Name
$admin_failed_order_greeting    = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name

// ***********************************************//
//            Admin New Order
// ***********************************************//
$admin_new_order_subtitle       = __('A new customer order has been placed.', 'bypierofracasso-woocommerce-emails'); // Header SubTitle
$admin_new_order_btn            = __('VIEW ORDER', 'bypierofracasso-woocommerce-emails'); // Button
$admin_new_order_hero_bg_img    = 'email-header-admin-new-order.png'; // Header Image File Name
$admin_new_order_greeting       = __('Hello', 'bypierofracasso-woocommerce-emails'); // Greeting Before User First Name

// ***********************************************//
//            Top Offer Customization
// ***********************************************//
$top_offer_show                = 'NO'; // Top Msg Show 'YES' or 'NO', Case Sensitive
$top_offer_text                = __('Starto 30% OFF →', 'bypierofracasso-woocommerce-emails');
$top_offer_link                = 'http://example.com/'; // URL

// ***********************************************//
//            Logo Width Customization
// ***********************************************//
$logoWidth                     = '130'; // Logo Width in Pixels – add only the number

// ***********************************************//
//            Menu Link Customization
// ***********************************************//
$menu_link_show                = "NO"; // Menu Links Show 'YES' or 'NO', Case Sensitive
$menu_divider_color            = '#81A6FF'; // Menu Divider Color
$menu_link_text_1              = __('Home', 'bypierofracasso-woocommerce-emails');
$menu_link_1                   = 'http://example.com/';
$menu_link_text_2              = __('About', 'bypierofracasso-woocommerce-emails');
$menu_link_2                   = 'http://example.com/';
$menu_link_text_3              = __('Blog', 'bypierofracasso-woocommerce-emails');
$menu_link_3                   = 'http://example.com/';
$menu_link_text_4              = __('Sale', 'bypierofracasso-woocommerce-emails');
$menu_link_4                   = 'http://example.com/';

// ***********************************************//
//            Other Product Customization
// ***********************************************//
$other_product_show            = 'YES'; // Other product Show 'YES' or 'NO', Case Sensitive
$other_product_title           = __('Your Fragrance Journey Starts Here', 'bypierofracasso-woocommerce-emails');
$other_product_1_img           = 'transaction@other-product-1.png'; // Image file name
$other_product_1_link          = 'https://bypierofracasso.com/product/samples/';
$other_product_1_title         = __('Try Our Samples', 'bypierofracasso-woocommerce-emails');
$other_product_1_price         = __('Six for CHF 18.00', 'bypierofracasso-woocommerce-emails');
$other_product_2_img           = 'transaction@other-product-2.png';
$other_product_2_link          = 'https://bypierofracasso.com/product/gift-card/';
$other_product_2_title         = __('Our Gift Cards', 'bypierofracasso-woocommerce-emails');
$other_product_2_price         = __('CHF 90.00 - CHF 280.00', 'bypierofracasso-woocommerce-emails');

// ***********************************************//
//            Banner Customization
// ***********************************************//
$banner_show                   = "NO"; // Banner Show 'YES' or 'NO', Case Sensitive
$banner_img                    = 'offer-banner.png'; // Banner Image File Name
$banner_link                   = 'http://example.com'; // Banner Link

// ***********************************************//
//            Footer App Customization
// ***********************************************//
$download_app_show             = "NO"; // Footer App Button Show 'YES' or 'NO', Case Sensitive
$footer_app_title              = __('Download Our App', 'bypierofracasso-woocommerce-emails');
$footer_app_1_img              = 'app-dark-ios-store.png'; // Image file name
$footer_app_1_link             = 'http://example.com';
$footer_app_2_img              = 'app-dark-android-store.png'; // Image file name
$footer_app_2_link             = 'http://example.com';

// ***********************************************//
//            Footer Info Customization
// ***********************************************//
$footer_info                   = __("If you have any questions or problems with your delivery, please visit our <br><a href='https://bypierofracasso.com/support'>Support Page</a>.<br> © byPieroFracasso | All rights reserved.", 'bypierofracasso-woocommerce-emails');

// ***********************************************//
//            Footer Social Icon Customization
// ***********************************************//
$footer_social_title           = __('Follow Us', 'bypierofracasso-woocommerce-emails');
$social_1_img                  = 'social-icon-facebook.png';
$social_1_link                 = 'https://www.facebook.com/people/Bypierofracasso-Perfumes/61572907035801/';
$social_2_img                  = 'social-icon-twitter.png';
$social_2_link                 = '';
$social_3_img                  = 'social-icon-instagram.png';
$social_3_link                 = 'https://www.instagram.com/bypierofracasso/';
$social_4_img                  = 'social-icon-linkedin.png';
$social_4_link                 = '';
$social_5_img                  = 'social-icon-pinterest.png';
$social_5_link                 = '';

// ***********************************************//
//            Footer Links Customization
// ***********************************************//
$footer_link_name_1            = __('FAQ', 'bypierofracasso-woocommerce-emails');
$footer_link_1                 = 'https://bypierofracasso.com/faq/';
$footer_link_name_2            = __('TERMS & CONDITIONS', 'bypierofracasso-woocommerce-emails');
$footer_link_2                 = 'https://bypierofracasso.com/terms-conditions/';
$footer_link_name_3            = __('SUPPORT', 'bypierofracasso-woocommerce-emails');
$footer_link_3                 = 'https://bypierofracasso.com/support/';
$footer_link_name_4            = __('CONTACT', 'bypierofracasso-woocommerce-emails');
$footer_link_4                 = 'https://bypierofracasso.com/contact-us/';
