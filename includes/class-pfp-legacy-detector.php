<?php
if (!defined('ABSPATH')) {
    exit;
}

class PFP_Legacy_Detector
{
    /**
     * Tracks whether the legacy warning has already been handled during the current request.
     *
     * @var bool
     */
    private $legacy_detected = false;

    /**
     * Register the detector on plugins_loaded.
     */
    public static function register()
    {
        $detector = new self();
        add_action('plugins_loaded', array($detector, 'maybe_warn'), 20);
    }

    /**
     * Check for legacy plugin artefacts and display/log warnings when found.
     */
    public function maybe_warn()
    {
        if (!$this->is_legacy_present()) {
            return;
        }

        if (!$this->legacy_detected) {
            bypf_log('[PFP] Legacy plugin detected alongside current version.', 'warning');
            $this->legacy_detected = true;
        }

        if (!is_admin()) {
            return;
        }

        if (!function_exists('current_user_can') || !current_user_can('manage_options')) {
            return;
        }

        add_action('admin_notices', array($this, 'render_notice'));
    }

    /**
     * Identify artefacts left by the legacy plugin.
     *
     * @return bool
     */
    private function is_legacy_present()
    {
        if (class_exists('byPieroFracasso_Email_Manager')) {
            return true;
        }

        if (defined('BYPF_EMAIL_MANAGER_VERSION')) {
            return true;
        }

        if (function_exists('bypierofracasso_emails_init')) {
            return true;
        }

        return false;
    }

    /**
     * Render the admin notice warning about the legacy plugin.
     */
    public function render_notice()
    {
        $message = __('Two versions of the Emails plugin are active (legacy + current). Please deactivate and remove the legacy plugin to avoid duplicate hooks and errors.', 'bypierofracasso-woocommerce-emails');

        echo '<div class="notice notice-error is-dismissible"><p>' . esc_html($message) . '</p></div>';
    }
}
