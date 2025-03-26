<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://yourwebsite.com
 * @since             1.0.0
 * @package           GoZupees_Affiliate_Product_Display
 *
 * @wordpress-plugin
 * Plugin Name:       GoZupees Affiliate Product Display
 * Plugin URI:        https://yourwebsite.com/plugins/gozupees-affiliate-product-display
 * Description:       Display affiliate product recommendations with your content.
 * Version:           1.1.1
 * Author:            Your Name
 * Author URI:        https://yourwebsite.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gozupees-affiliate-product-display
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_VERSION', '1.1.1' );
define( 'GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_NAME', 'gozupees-affiliate-product-display' );
define( 'GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_PATH', plugin_dir_path( __FILE__ ) );
define( 'GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gozupees-affiliate-product-display.php
 */
function activate_gozupees_affiliate_product_display() {
    require_once GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_PATH . 'includes/class-gozupees-affiliate-product-display.php';
    $plugin = new GoZupees_Affiliate_Product_Display_Plugin();
    $plugin->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gozupees-affiliate-product-display.php
 */
function deactivate_gozupees_affiliate_product_display() {
    require_once GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_PATH . 'includes/class-gozupees-affiliate-product-display.php';
    $plugin = new GoZupees_Affiliate_Product_Display_Plugin();
    $plugin->deactivate();
}

register_activation_hook( __FILE__, 'activate_gozupees_affiliate_product_display' );
register_deactivation_hook( __FILE__, 'deactivate_gozupees_affiliate_product_display' );

/**
 * Include the updater class only if the required structure exists
 */
$updater_class_path = GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_PATH . 'includes/class-gozupees-affiliate-product-display-updater.php';
if (file_exists($updater_class_path)) {
    require_once $updater_class_path;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_PATH . 'includes/class-gozupees-affiliate-product-display.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gozupees_affiliate_product_display() {
    $plugin = new GoZupees_Affiliate_Product_Display_Plugin();
    $plugin->run();
    
    // Initialize the update checker only if the class exists
    if (class_exists('GoZupees_Affiliate_Product_Display_Updater')) {
        $updater = new GoZupees_Affiliate_Product_Display_Updater();
        $updater->init();
    }
}
run_gozupees_affiliate_product_display();
