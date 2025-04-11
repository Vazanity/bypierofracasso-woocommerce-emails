# Changelog

All notable changes to the byPieroFracasso WooCommerce Emails plugin will be documented in this file.

## [1.0.23] - 2025-04-11
### Fixed
  - Updated class-files to comply with WPML textdomains:
    - class-wc-email-customer-invoice.php
    - class-wc-email-shipped-order.php
    - class-wc-email-ready-for-pickup.php
  - Updated class file class-wc-email-customer-invoice.php, text was german, should be english as main language.
  - Bumped plugin version to 1.0.23.

## [1.0.22] - 2025-03-30
### Fixed
  - Updated all email template texts for better clarity and customer engagement.
  - Fixed issue with "Order Shipped" and "Ready for Pickup" emails being incorrectly sent to admin; now correctly sent to customers.
  - Added centralized text definitions in wc-settings.php; all email texts are now managed from this single file.
  - Bumped plugin version to 1.0.22.
  - Included minor improvements, code tweaks, and bug fixes for stability and performance.

## [1.0.21] - 2025-03-28
### Fixed
- Prevented the "Customer Processing Order" email from being sent automatically after the "Order Received" email when the order status is `wc-received` (by Umair).
  - Added a new hook to override WooCommerce's default behavior of setting new orders to `processing`.
  - Ensured only the custom `wc-received` status is set for new orders, stopping the `processing` email from being triggered.

## [1.0.20] - 2025-03-20
### Fixed
- Fixed email trigger issues for custom statuses (`shipped`, `ready-for-pickup`, `pending-payment`, `received`) (by Umair).
  - Adjusted hook priorities (e.g., set `woocommerce_order_status_changed` to priority 9999).
  - Removed `wc-` prefix from status checks to align with email classes.
  - Corrected template file paths in email classes (e.g., `customer-order-shipped.php`, `customer-order-ready-for-pickup.php`).
- Fixed a fatal error in `email-order-items.php` by adding validation for invalid products (prevented `Call to a member function get_image_id() on bool`).
### Added
- Added debug logging to track email triggers and status changes in `byPieroFracasso_WooCommerce_Emails.php` and `class-email-manager.php`.
- Added `BPF_WC_Email_Customer_Processing_Order` class to prevent the "Customer Processing Order" email from sending unless the status is explicitly `processing`.
- Added status protection in `byPieroFracasso_WooCommerce_Emails.php` to block automatic transitions to `processing` after `wc-received`.

## [1.0.19] - 2025-03-01 (Assumed)
### Added
- Initial setup of custom order statuses: `wc-received`, `wc-pending-payment`, `wc-shipped`, `wc-ready-for-pickup`.
- Added custom email classes: `WC_Email_Order_Received`, `WC_Email_Pending_Order`, `WC_Email_Shipped_Order`, `WC_Email_Ready_For_Pickup`.
- Implemented email template overrides and custom styling for emails.

## [Unreleased]
### Planned
- Refine email templates for improved design and content in the next version.
