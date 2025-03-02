<?php
/*
Plugin Name: byPieroFracasso WooCommerce Emails
Plugin URI: https://bypierofracasso.com/
Description: Steuert alle WooCommerce-E-Mails und deaktiviert nicht benötigte Standardmails.
Version: 1.0.0
Author: byPieroFracasso
Author URI: https://bypierofracasso.com/
License: GPLv2 or later
Text Domain: bypierofracasso-woocommerce-emails
*/

if (!defined('ABSPATH')) {
    exit; // Sicherheit: Direkter Zugriff verhindern
}

// Plugin-Version definieren
define('BYPF_EMAILS_VERSION', '1.0.0');

// E-Mail-Manager laden
require_once plugin_dir_path(__FILE__) . 'includes/class-email-manager.php';

// Plugin initialisieren
function bypierofracasso_woocommerce_emails_init() {
    new byPieroFracasso_Email_Manager();
}
add_action('plugins_loaded', 'bypierofracasso_woocommerce_emails_init');
