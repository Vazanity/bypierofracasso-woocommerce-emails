# Piero Fracasso Perfumes WooCommerce Emails

**Stable tag:** 1.2.6.11

## Overview
The **Piero Fracasso Perfumes WooCommerce Emails** plugin is a custom WordPress plugin designed to enhance the email functionality of WooCommerce for the Piero Fracasso Perfumes online store. It introduces custom order statuses, corresponding email notifications, and overrides default WooCommerce email templates with branded versions. The plugin also disables unnecessary default WooCommerce emails to streamline notifications.

## Features
- **Custom Order Statuses**:
  - `wc-received`: Indicates an order has been received after payment.
  - `wc-pending-payment`: Indicates an order is awaiting payment.
  - `wc-shipped`: Indicates an order has been shipped.
  - `wc-ready-for-pickup`: Indicates an order is ready for customer pickup.
- **Custom Email Notifications**:
  - **Order Received**: Sent when an order status changes to `wc-received`.
  - **Pending Order**: Sent for orders in `wc-pending-payment` status.
  - **Shipped Order**: Sent when an order status changes to `wc-shipped`.
  - **Ready for Pickup**: Sent when an order status changes to `wc-ready-for-pickup`.
  - **Customer Payment Failed**: Sent when a payment fails.
- **Custom Email Templates**:
  - Overrides default WooCommerce email templates with branded versions located in `templates/emails/`.
  - Includes plain text versions in `templates/emails/plain/`.
- **Disable Default Emails**:
- **Payment Gateway:** Provides a 'Rechnung (Swiss QR)' option that sets the order status to invoice and attaches a QR invoice PDF.
  - Admins can enable checkout diagnostics and force visibility for testing via filter `pfp_invoice_force_visible`.
  - WooCommerce Blocks checkout wird unterstützt.
  - Disables unnecessary WooCommerce emails like payment retry, renewal invoices, and certain failed order emails to reduce notification clutter.
- **Debugging Support**:
  - Extensive debug logging to track email triggers, status changes, and plugin activity.
  - Manual email trigger via URL parameter (`?bypf_trigger_email=ORDER_ID`) for testing.

## Installation
1. Download the plugin as a `.zip` file.
2. In your WordPress admin panel, go to `Plugins > Add New > Upload Plugin`.
3. Upload the `.zip` file and activate the plugin.
4. Configure email settings in `WooCommerce > Settings > Emails` to enable/disable notifications and set recipients.

## Usage
- **Custom Statuses**: The plugin automatically adds custom order statuses to WooCommerce. You can set an order to these statuses via the admin panel or programmatically.
- **Swiss QR Invoice Payment:** Enable the 'Rechnung (Swiss QR)' gateway under WooCommerce > Payments and configure a QR-IBAN or IBAN plus creditor data.
- **Email Notifications**: Emails are triggered when an order status changes to one of the custom statuses. Ensure the emails are enabled in WooCommerce settings.
- **Debugging**:
  - Enable WordPress debugging in `wp-config.php`:
    ```php
    define('WP_DEBUG', true);
    define('WP_DEBUG_LOG', true);
    define('WP_DEBUG_DISPLAY', false);
    ```
    This keeps logs in `wp-content/debug.log` without exposing errors to visitors.

### Translations
- All PHP and JavaScript strings share the `bypierofracasso-woocommerce-emails` text domain.
- Translation files live in the bundled `languages/` directory (`Domain Path: /languages`).
- Generate or refresh a POT via `wp i18n make-pot . languages/bypierofracasso-woocommerce-emails.pot --domain=bypierofracasso-woocommerce-emails`.

### JimSoft Migration
The plugin replaces the legacy *JimSoft QR-Invoice* extension. If that plugin is active, a warning is shown; please deactivate JimSoft to avoid conflicts.

### Deployment
WordPress 5.5+ supports replacing the plugin by uploading a ZIP with the same folder name. Increase the version (currently `1.2.6.11`) so WordPress detects the update. JimSoft can remain installed but must stay deactivated.

The released ZIP now includes the `vendor/` directory, so no Composer installation is required on production systems.

### Error Handling
If required QR invoice settings (e.g. CHF currency and at least one QR-IBAN or IBAN) are missing, PDF attachments are skipped gracefully and a log entry is written – no fatal errors occur.

## Testing
- Staging: verified rendering of customer invoice, order received, processing, and shipped emails.
- Plugin-Checker: no remaining escaping, i18n, nonce, or logging issues reported.
