# Changelog

## 1.2.6.5
- Fix: Deferred all translations to post-init usage to satisfy WP 6.7+ i18n timing.
- Add: Admin legacy detector to warn when an old plugin version is loaded in parallel.
- Chore: Reduced repetitive debug logs (product type selector, email registry).

## [1.2.6.4] - 2025-09-16
### Changed
- Refactor: unified all PHP/JS strings to text domain `bypierofracasso-woocommerce-emails`.
- Fix: load text domain on `init` to avoid early-translation notices.
- Feature: enabled JS translations for Blocks handle via `wp_set_script_translations`.

## [1.2.6.3] - 2025-09-15
### Changed
- Fixed early textdomain load, hardened Blocks registration (IntegrationRegistry + legacy filter), robust script handle, and added admin-only diagnostics.

## [1.2.6.2] - 2025-09-14
### Changed
- Hardened Classic/Blocks registration using official WooCommerce APIs.
- Ensured supports = products and unified gateway ID.
- Added admin-only diagnostics for availability and blocks activation.
- No icons added.

## [1.2.6-hotfix] - 2025-09-14
### Changed
- Hardened Classic/Blocks registration using official WooCommerce hooks; added admin-only instrumentation; kept IBAN rules.

## [1.2.6] - 2025-09-14
### Added
- Added WooCommerce Blocks checkout support for the Invoice gateway.

## [1.2.5] - 2025-09-13
### Changed
- Classic checkout visibility fixed; enforce QR-IBAN OR IBAN (one required); removed all icon code.

## [1.2.4] - 2025-09-13
### Added
- Admin icon in payment list
- Classic + Blocks checkout support finalized for pfp_invoice
- Icon fallback to inline SVG; PNG at assets/img/qr-gateway-icon.png if present

## [1.2.3] - 2025-09-13
### Added
- Feature: Gateway-Icon vorbereitet (PNG im Plugin unter assets/img/qr-gateway-icon.png), Fallback auf Inline-SVG, keine Binärdateien im PR.

## [1.2.2] - 2025-09-13
### Added
- Binärfreie Icon-Integration (Inline-SVG + Icon-URL Setting).
### Chore
- Packaging-Regeln für Releases.

## [1.2.1] - 2025-09-13
### Fixed
- Gateway sichtbar im Checkout – korrigierte `is_available()`-Logik, Admin-Diagnose, Test-Force-Visible.
### Added
- Gateway-Icon (`assets/img/qr-gateway-icon.png`).
### Chore
- Keine JimSoft-Assets (`swiss-qr-bill`/`tcpdf_min`); Composer-Vendor bleibt Quelle der Wahrheit.

## [1.2.0] - 2025-09-13
### Added
- Feature: New payment gateway 'Rechnung (Swiss QR)', sets order status invoice, auto-attaches QR invoice PDF; WPML-ready; JimSoft replacement.


All notable changes to the Piero Fracasso Perfumes WooCommerce Emails plugin will be documented in this file.
## [1.1.5] - 2025-09-12
### Fixed
- Fix packaging (bundled vendor and autoloader)
- Remove hidden files from release
- Full Plugin Checker compliance (escaping/i18n/nonce/logging)
- Hardened bootstrap and logger fallback

## [1.1.4] - 2025-09-11
### Fixed
- Fix: Packaged vendor/ to eliminate 'Missing dependencies'.
- Hardened bootstrap & logger fallback.
- Full Plugin Checker compliance (escaping/i18n/nonce/logging).


## [1.1.3] - 2025-09-10
### Fixed
- Fix: Prevent fatal when `wc_get_logger()` is unavailable by delaying plugin bootstrap until WooCommerce loads and providing a logger fallback.

## [1.1.2] - 2025-09-09
### Fixed
- Fix: Plugin-Checker Compliance (escaping/i18n/nonce/logging).

## [1.1.1] - 2025-09-08
### Fixed
- Added guard checks to prevent fatal errors when WooCommerce or dependencies are missing.
- Plugin initialization now waits until `plugins_loaded` priority 11 and verifies WooCommerce availability.
- Avoids duplicate QR invoice functionality by detecting active JimSoft plugins and showing an admin warning.
- Composer autoloader is loaded only when present, otherwise an admin notice is displayed.

## [1.1.0] - 2025-09-08
### Added
  - Introduced custom `invoice` order status with bulk action support and automatic assignment for configured payment methods.
### Changed
  - Rebranded plugin strings to "Piero Fracasso Perfumes" and switched text domain to `piero-fracasso-emails`.
  - Kept email item prices on one line and cleaned up label colons.
  - Bumped plugin version to 1.1.0.

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
- Added debug logging to track email triggers and status changes in `Piero Fracasso Perfumes_WooCommerce_Emails.php` and `class-email-manager.php`.
- Added `BPF_WC_Email_Customer_Processing_Order` class to prevent the "Customer Processing Order" email from sending unless the status is explicitly `processing`.
- Added status protection in `Piero Fracasso Perfumes_WooCommerce_Emails.php` to block automatic transitions to `processing` after `wc-received`.

## [1.0.19] - 2025-03-01 (Assumed)
### Added
- Initial setup of custom order statuses: `wc-received`, `wc-pending-payment`, `wc-shipped`, `wc-ready-for-pickup`.
- Added custom email classes: `WC_Email_Order_Received`, `WC_Email_Pending_Order`, `WC_Email_Shipped_Order`, `WC_Email_Ready_For_Pickup`.
- Implemented email template overrides and custom styling for emails.

## [Unreleased]
### Planned
- Refine email templates for improved design and content in the next version.
