<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://yourwebsite.com
 * @since      1.0.0
 *
 * @package    GoZupees_Affiliate_Product_Display
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Delete plugin options
delete_option( 'gozupees_affiliate_product_display_options' );

// Delete post meta for all affiliate products
global $wpdb;
$wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE '\_product\_%'" );

// Remove all posts of our custom post type and related data
$posts = get_posts(
    array(
        'post_type'      => 'affiliate_product',
        'posts_per_page' => -1,
        'post_status'    => 'any',
    )
);

foreach ( $posts as $post ) {
    wp_delete_post( $post->ID, true );
}

// Clear any cached data that has been added by the plugin
wp_cache_flush();
