# Piero Fracasso Perfumes WooCommerce Emails

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
- **Email Notifications**: Emails are triggered when an order status changes to one of the custom statuses. Ensure the emails are enabled in WooCommerce settings.
- **Debugging**:
  - Enable WordPress debugging in `wp-config.php`:
    ```php
    define('WP_DEBUG', true);
    define('WP_DEBUG_LOG', true);
    define('WP_DEBUG_DISPLAY', false);
