<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://yourwebsite.com
 * @since      1.0.0
 *
 * @package    GoZupees_Affiliate_Product_Display
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    GoZupees_Affiliate_Product_Display
 * @author     Your Name <email@example.com>
 */
class GoZupees_Affiliate_Product_Display_Public {

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style('gozupees-affiliate-product-display-style', GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_URL . 'assets/css/style.css', array(), GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_VERSION, 'all');
        wp_enqueue_style('gozupees-affiliate-product-display-enhanced-style', GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_URL . 'assets/css/enhanced-style.css', array('gozupees-affiliate-product-display-style'), GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_VERSION, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_script('gozupees-affiliate-bookmark', GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_URL . 'assets/js/bookmark.js', array('jquery'), GOZUPEES_AFFILIATE_PRODUCT_DISPLAY_VERSION, true);
    }

    /**
     * Register shortcodes
     */
    public function register_shortcodes() {
        add_shortcode('affiliate_product', array($this, 'product_shortcode'));
        add_shortcode('affiliate_products', array($this, 'products_list_shortcode'));
    }

    /**
     * Shortcode function for single product
     */
    public function product_shortcode($atts) {
        $atts = shortcode_atts(
            array(
                'id' => 0,
            ),
            $atts,
            'affiliate_product'
        );
        
        if (empty($atts['id'])) {
            return '<p>Please provide a product ID.</p>';
        }
        
        $product_id = intval($atts['id']);
        
        // Check if post exists and is the correct type
        if (!get_post($product_id) || get_post_type($product_id) !== 'affiliate_product') {
            return '<p>Invalid product ID.</p>';
        }
        
        return $this->render_product($product_id);
    }
    
    /**
     * Shortcode function for multiple products
     */
    public function products_list_shortcode($atts) {
        $atts = shortcode_atts(
            array(
                'count' => 3,
                'category' => '',
            ),
            $atts,
            'affiliate_products'
        );
        
        $args = array(
            'post_type' => 'affiliate_product',
            'posts_per_page' => intval($atts['count']),
            'post_status' => 'publish',
        );
        
        if (!empty($atts['category'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $atts['category'],
                ),
            );
        }
        
        $products = new WP_Query($args);
        
        $output = '';
        
        if ($products->have_posts()) {
            while ($products->have_posts()) {
                $products->the_post();
                $output .= $this->render_product(get_the_ID());
            }
            wp_reset_postdata();
        } else {
            $output = '<p>No products found.</p>';
        }
        
        return $output;
    }
    
    /**
     * Render product HTML
     */
    public function render_product($product_id) {
        wp_enqueue_style('gozupees-affiliate-product-display-style');
        wp_enqueue_style('gozupees-affiliate-product-display-enhanced-style');
        wp_enqueue_script('gozupees-affiliate-bookmark');

        $title = get_the_title($product_id);
        $description = get_the_excerpt($product_id);
        
        $brand = get_post_meta($product_id, '_product_brand', true);
        $price = get_post_meta($product_id, '_product_price', true);
        $currency_symbol = get_post_meta($product_id, '_product_currency_symbol', true) ?: '$';
        $compare_price = get_post_meta($product_id, '_product_compare_price', true);
        $affiliate_link = get_post_meta($product_id, '_product_affiliate_link', true);
        $rating = get_post_meta($product_id, '_product_rating', true);
        $reviews_count = get_post_meta($product_id, '_product_reviews_count', true);
        $weight = get_post_meta($product_id, '_product_weight', true);
        $store = get_post_meta($product_id, '_product_store', true);
        $short_description = get_post_meta($product_id, '_product_short_description', true);
        $tag = get_post_meta($product_id, '_product_tag', true);
        $features = get_post_meta($product_id, '_product_features', true);
        
        // Get thumbnail
        $thumbnail = get_the_post_thumbnail_url($product_id, 'full');
        
        // Start building output
        ob_start();
        ?>
    <div class="affiliate-product-container-wrapper">
        <!-- Bookmark icon positioned absolutely -->
        
        <div class="affiliate-product-container">
            <div class="affiliate-product-bookmark">
            <span class="bookmark-icon" data-product-id="<?php echo esc_attr($product_id); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                </svg>
            </span>
        </div>      
            <div class="affiliate-product-image">
                <?php if ($thumbnail) : ?>
                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>">
                <?php else : ?>
                    <div class="no-image">No Image Available</div>
                <?php endif; ?>
            </div>
            <div class="affiliate-product-details">
                <a href="<?php echo esc_url($affiliate_link); ?>" target="_blank" rel="nofollow noopener" class="affiliate-product-link trackingLink">
                <?php if ($brand) : ?>
                    <div class="affiliate-product-brand"><?php echo esc_html($brand); ?></div>
                <?php endif; ?>
                <div class="affiliate-product-header">
                    <div class="affiliate-product-title-wrapper">

                        <div class="affiliate-product-title">
                            <?php echo esc_html($title); ?>
                        </div>
                        <?php if ($tag) : ?>
                            <span class="affiliate-product-tag"><?php echo esc_html($tag); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($rating || $reviews_count) : ?>
                    <div class="affiliate-product-ratings">
                        <?php if ($rating) : ?>
                            <div class="affiliate-product-rating">
                                <?php echo esc_html(number_format($rating, 1)); ?>
                                <div class="affiliate-product-stars">
                                    <?php
                                    $rating_int = floor($rating);
                                    $rating_decimal = $rating - $rating_int;
                                    
                                    // Full stars
                                    for ($i = 0; $i < $rating_int; $i++) {
                                        echo '<span class="affiliate-product-star full">★</span>';
                                    }
                                    
                                    // Half star if needed
                                    if ($rating_decimal >= 0.25 && $rating_decimal < 0.75) {
                                        echo '<span class="affiliate-product-star half">★</span>';
                                        $i++;
                                    } else if ($rating_decimal >= 0.75) {
                                        echo '<span class="affiliate-product-star full">★</span>';
                                        $i++;
                                    }
                                    
                                    // Empty stars
                                    for (; $i < 5; $i++) {
                                        echo '<span class="affiliate-product-star empty">★</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($reviews_count) : ?>
                            <div class="affiliate-product-reviews-count">(<?php echo number_format($reviews_count); ?>)</div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($short_description) : ?>
                    <div class="affiliate-product-short-description">
                        <?php echo esc_html($short_description); ?>
                    </div>
                <?php endif; ?>

                <?php if ($features) : ?>
                    <div class="affiliate-product-features">
                        <?php
                        $features_array = array_map('trim', explode(',', $features));
                        echo '<ul>';
                        foreach ($features_array as $feature) {
                            echo '<li>' . esc_html($feature) . '</li>';
                        }
                        echo '</ul>';
                        ?>
                    </div>
                <?php endif; ?>

                <div class="affiliate-product-footer">
                    <div class="affiliate-product-price-container">
                        <?php if ($price) : ?>
                            <div class="affiliate-product-price">
                                <?php echo esc_html($currency_symbol) . esc_html($price); ?>
                                
                                <?php if ($compare_price && $compare_price > $price) : ?>
                                    <span class="affiliate-product-compare-price">
                                        <?php echo esc_html($currency_symbol) . esc_html($compare_price); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($weight) : ?>
                            <div class="affiliate-product-weight"><?php echo esc_html($weight); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="affiliate-product-button-container">
                        <div class="affiliate-product-button">View Details</div>
                        <?php if ($store) : ?>
                            <div class="affiliate-product-store">on <?php echo esc_html($store); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
        <?php
        return ob_get_clean();
    }
}