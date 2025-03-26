<?php
/**
 * Plugin Updater
 *
 * @link       https://yourwebsite.com
 * @since      1.0.0
 *
 * @package    GoZupees_Affiliate_Product_Display
 */

/**
 * Plugin updater class.
 *
 * This class handles automatic updates for the plugin.
 * It uses the Plugin Update Checker library (https://github.com/YahnisElsts/plugin-update-checker)
 * which needs to be included in your plugin.
 *
 * @since      1.0.0
 * @package    GoZupees_Affiliate_Product_Display
 * @author     Your Name <email@example.com>
 */
class GoZupees_Affiliate_Product_Display_Updater {

    /**
     * Initialize the updater.
     *
     * @since    1.0.0
     */
    public function init() {
        // Check if the Plugin Update Checker library exists
        if (!$this->include_puc_library()) {
            // Add admin notice if the library couldn't be included
            add_action('admin_notices', array($this, 'puc_missing_notice'));
            return;
        }

        // Set up the update checker
        $this->setup_update_checker();
    }

    /**
     * Include the Plugin Update Checker library.
     *
     * @since    1.0.0
     * @return   boolean    True if the library was included, false otherwise.
     */
    private function include_puc_library() {
        // Path to the library file
        $puc_path = GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_PATH . 'vendor/plugin-update-checker/plugin-update-checker.php';
        
        // Check if the library exists
        if (!file_exists($puc_path)) {
            // For debugging purposes, log if the file doesn't exist
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('GoZupees Affiliate Product Display: PUC library not found at ' . $puc_path);
            }
            return false;
        }
        
        // Include the library
        require_once $puc_path;
        return class_exists('Puc_v4_Factory');
    }
    
    /**
     * Set up the update checker.
     *
     * @since    1.0.0
     */
    private function setup_update_checker() {
        if (!class_exists('Puc_v4_Factory')) {
            return;
        }
        
        // Initialize the update checker.
        // This points to your existing GitHub repository
        $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
            'https://github.com/gozupees/gozupees-affiliate-product-display/', // Your existing GitHub repository
            GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_PATH . 'gozupees-affiliate-product-display.php',
            'gozupees-affiliate-product-display'
        );
        
        // Set the branch that contains the stable release.
        $myUpdateChecker->setBranch('main');
        
        // Optional: If you're using a private repository, set the authentication credentials.
        // $myUpdateChecker->setAuthentication('your-access-token');
        
        // Optional: If you're hosting the plugin somewhere other than GitHub:
        /*
        $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
            'https://example.com/plugin-updates/gozupees-affiliate-product-display/info.json',
            GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_PATH . 'gozupees-affiliate-product-display.php',
            'gozupees-affiliate-product-display'
        );
        */
    }
    
    /**
     * Display an admin notice if the Plugin Update Checker library is missing.
     *
     * @since    1.0.0
     */
    public function puc_missing_notice() {
        ?>
        <div class="notice notice-error">
            <p><?php esc_html_e('The Plugin Update Checker library is missing. GoZupees Affiliate Product Display will not be able to check for updates automatically.', 'gozupees-affiliate-product-display'); ?></p>
        </div>
        <?php
    }
}