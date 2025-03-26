<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://yourwebsite.com
 * @since      1.0.0
 *
 * @package    GoZupees_Affiliate_Product_Display
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for the admin area including
 * the custom post type, meta boxes, and admin settings.
 *
 * @package    GoZupees_Affiliate_Product_Display
 * @author     Your Name <email@example.com>
 */
class GoZupees_Affiliate_Product_Display_Admin {

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style( 'gozupees-affiliate-product-display-admin', GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_URL . 'admin/css/gozupees-affiliate-product-display-admin.css', array(), GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_VERSION, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_script( 'gozupees-affiliate-product-display-admin', GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_URL . 'admin/js/gozupees-affiliate-product-display-admin.js', array( 'jquery' ), GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_VERSION, false );
    }

    /**
     * Register custom post type for products
     */
    public function register_product_post_type() {
        $args = array(
            'public' => true,
            'label' => 'Affiliate Products',
            'labels' => array(
                'name' => 'Affiliate Products',
                'singular_name' => 'Affiliate Product',
                'add_new' => 'Add New Product',
                'add_new_item' => 'Add New Affiliate Product',
                'edit_item' => 'Edit Affiliate Product',
                'view_item' => 'View Affiliate Product',
            ),
            'supports' => array('title', 'thumbnail', 'editor'),
            'menu_icon' => 'dashicons-cart',
            'show_in_menu' => true,
            'has_archive' => false,
        );
        
        register_post_type('affiliate_product', $args);
    }
    
    /**
     * Add meta boxes for product details
     */
    public function add_product_meta_boxes() {
        add_meta_box(
            'affiliate_product_details',
            'Product Details',
            array($this, 'product_details_meta_box'),
            'affiliate_product',
            'normal',
            'high'
        );
    }
    
    /**
     * Output the product details meta box
     */
    public function product_details_meta_box($post) {
        // Add nonce for security
        wp_nonce_field('affiliate_product_meta_box', 'affiliate_product_meta_box_nonce');
        
        // Get existing values
        $brand = get_post_meta($post->ID, '_product_brand', true);
        $price = get_post_meta($post->ID, '_product_price', true);
        $currency_symbol = get_post_meta($post->ID, '_product_currency_symbol', true) ?: '$';
        $compare_price = get_post_meta($post->ID, '_product_compare_price', true);
        $affiliate_link = get_post_meta($post->ID, '_product_affiliate_link', true);
        $rating = get_post_meta($post->ID, '_product_rating', true);
        $reviews_count = get_post_meta($post->ID, '_product_reviews_count', true);
        $weight = get_post_meta($post->ID, '_product_weight', true);
        $store = get_post_meta($post->ID, '_product_store', true);
        $short_description = get_post_meta($post->ID, '_product_short_description', true);
        $tag = get_post_meta($post->ID, '_product_tag', true);
        $features = get_post_meta($post->ID, '_product_features', true);
        
        ?>
        <div class="affiliate-product-meta-box">
            <p>
                <label for="product_brand">Brand:</label>
                <input type="text" id="product_brand" name="product_brand" value="<?php echo esc_attr($brand); ?>" class="widefat">
            </p>
            <p>
                <label for="product_tag">Product Tag (e.g. "New", "Sale"):</label>
                <input type="text" id="product_tag" name="product_tag" value="<?php echo esc_attr($tag); ?>" class="regular-text">
                <span class="description">Optional tag to display next to product title</span>
            </p>
            <p>
                <label for="product_price">Price:</label>
                <input type="text" id="product_price" name="product_price" value="<?php echo esc_attr($price); ?>" class="widefat">
                <span class="description">Enter the price without currency symbol (e.g. 20)</span>
            </p>
            <p>
                <label for="product_currency_symbol">Currency Symbol:</label>
                <input type="text" id="product_currency_symbol" name="product_currency_symbol" value="<?php echo esc_attr($currency_symbol); ?>" class="small-text">
                <span class="description">E.g. "$", "€", or "£"</span>
            </p>
            <p>
                <label for="product_compare_price">Compare At Price:</label>
                <input type="text" id="product_compare_price" name="product_compare_price" value="<?php echo esc_attr($compare_price); ?>" class="regular-text">
                <span class="description">Higher original price to show discount (without currency symbol)</span>
            </p>
            <p>
                <label for="product_affiliate_link">Affiliate Link:</label>
                <input type="url" id="product_affiliate_link" name="product_affiliate_link" value="<?php echo esc_url($affiliate_link); ?>" class="widefat">
            </p>
            <p>
                <label for="product_rating">Rating (out of 5):</label>
                <input type="number" id="product_rating" name="product_rating" value="<?php echo esc_attr($rating); ?>" min="0" max="5" step="0.1" class="widefat">
            </p>
            <p>
                <label for="product_reviews_count">Number of Reviews:</label>
                <input type="number" id="product_reviews_count" name="product_reviews_count" value="<?php echo esc_attr($reviews_count); ?>" min="0" class="widefat">
            </p>
            <p>
                <label for="product_weight">Weight:</label>
                <input type="text" id="product_weight" name="product_weight" value="<?php echo esc_attr($weight); ?>" class="widefat">
                <span class="description">E.g. "5-lb bag", "30 days supply", etc.</span>
            </p>
            <p>
                <label for="product_store">Store Name:</label>
                <input type="text" id="product_store" name="product_store" value="<?php echo esc_attr($store); ?>" class="widefat">
                <span class="description">E.g. "Amazon", "Walmart", "Target"</span>
            </p>
            <p>
                <label for="product_short_description">Short Description:</label>
                <textarea id="product_short_description" name="product_short_description" class="widefat" rows="3"><?php echo esc_textarea($short_description); ?></textarea>
                <span class="description">A brief description of the product (1-2 sentences)</span>
            </p>
            <p>
                <label for="product_features">Features:</label>
                <textarea id="product_features" name="product_features" class="widefat" rows="3"><?php echo esc_textarea($features); ?></textarea>
                <span class="description">Comma-separated list of features (e.g. "Made in USA, Eco-Friendly, Sustainable")</span>
            </p>
        </div>
        <?php
    }
    
    /**
     * Save product meta data
     */
    public function save_product_meta($post_id) {
        // Security checks
        if (!isset($_POST['affiliate_product_meta_box_nonce'])) {
            return;
        }
        
        if (!wp_verify_nonce($_POST['affiliate_product_meta_box_nonce'], 'affiliate_product_meta_box')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Save meta data
        if (isset($_POST['product_brand'])) {
            update_post_meta($post_id, '_product_brand', sanitize_text_field($_POST['product_brand']));
        }
        
        if (isset($_POST['product_tag'])) {
            update_post_meta($post_id, '_product_tag', sanitize_text_field($_POST['product_tag']));
        }
        
        if (isset($_POST['product_price'])) {
            update_post_meta($post_id, '_product_price', sanitize_text_field($_POST['product_price']));
        }

        if (isset($_POST['product_currency_symbol'])) {
            update_post_meta($post_id, '_product_currency_symbol', sanitize_text_field($_POST['product_currency_symbol']));
        }

        if (isset($_POST['product_compare_price'])) {
            update_post_meta($post_id, '_product_compare_price', sanitize_text_field($_POST['product_compare_price']));
        }
        
        if (isset($_POST['product_affiliate_link'])) {
            update_post_meta($post_id, '_product_affiliate_link', esc_url_raw($_POST['product_affiliate_link']));
        }
        
        if (isset($_POST['product_rating'])) {
            update_post_meta($post_id, '_product_rating', sanitize_text_field($_POST['product_rating']));
        }
        
        if (isset($_POST['product_reviews_count'])) {
            update_post_meta($post_id, '_product_reviews_count', intval($_POST['product_reviews_count']));
        }
        
        if (isset($_POST['product_weight'])) {
            update_post_meta($post_id, '_product_weight', sanitize_text_field($_POST['product_weight']));
        }
        
        if (isset($_POST['product_store'])) {
            update_post_meta($post_id, '_product_store', sanitize_text_field($_POST['product_store']));
        }
        
        if (isset($_POST['product_short_description'])) {
            update_post_meta($post_id, '_product_short_description', sanitize_textarea_field($_POST['product_short_description']));
        }
        
        if (isset($_POST['product_features'])) {
            update_post_meta($post_id, '_product_features', sanitize_textarea_field($_POST['product_features']));
        }
    }

    /**
     * Add plugin action links.
     *
     * Add a link to the settings page on the plugins.php page.
     *
     * @since    1.0.0
     * @param    array    $links    The existing plugin action links.
     * @return   array              The modified plugin action links.
     */
    public function plugin_action_links( $links ) {
        $settings_link = array(
            '<a href="' . admin_url( 'edit.php?post_type=affiliate_product' ) . '">' . __( 'Manage Products', 'gozupees-affiliate-product-display' ) . '</a>',
        );
        
        return array_merge( $settings_link, $links );
    }
}