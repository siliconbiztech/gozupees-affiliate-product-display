=== GoZupees Affiliate Product Display ===
Contributors: yourname
Tags: affiliate, products, showcase, marketing, display
Requires at least: 5.6
Tested up to: 6.4
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display beautiful affiliate product showcases with affiliate links in your content.

== Description ==

GoZupees Affiliate Product Display is a powerful WordPress plugin that allows you to create and display beautiful, conversion-optimized affiliate product showcases on your website. 

The plugin creates a custom post type for affiliate products where you can store all the details about the products you want to showcase, including:

* Product brand
* Price information
* Affiliate links
* Product ratings and reviews
* Product features
* Images and descriptions

You can then display these products anywhere on your site using simple shortcodes.

**Key Features:**

* Custom post type for managing affiliate products
* Beautiful product showcase with responsive design
* Detailed product information fields (brand, price, rating, etc.)
* Client-side bookmarking functionality
* Two shortcodes: one for single product and one for product lists
* Automatic update functionality - no more manual updates

== Installation ==

1. Upload `gozupees-affiliate-product-display` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Start creating affiliate products under the "Affiliate Products" menu item
4. Use the shortcodes to display products in your content:
   * `[affiliate_product id="123"]` - displays a single product
   * `[affiliate_products count="3" category="electronics"]` - displays multiple products

== Frequently Asked Questions ==

= How do I add a new affiliate product? =

1. Go to Affiliate Products → Add New
2. Enter a title for your product
3. Add a featured image (this will be the product image)
4. Fill in all the product details in the Product Details meta box
5. Publish your product

= How do I display products on my site? =

Use one of these shortcodes:

* For a single product: `[affiliate_product id="123"]` (replace 123 with your product ID)
* For multiple products: `[affiliate_products count="3" category="electronics"]`

= Does this plugin work with any WordPress theme? =

Yes! The plugin is designed to work with any properly coded WordPress theme.

= How do automatic updates work? =

The plugin uses the Plugin Update Checker library to check for updates from the GitHub repository. When a new version is detected, WordPress will notify you of the update which you can install with one click.

== Changelog ==

= 1.1.1 =
* Fixed critical issue with plugin update mechanism
* Bundled Plugin Update Checker library directly in the plugin
* Improved error handling during plugin activation
* Enhanced plugin stability when server permissions are limited

= 1.1.0 =
* Added client-side bookmarking functionality
* Improved responsive design
* Added automatic update functionality
* Bug fixes and performance improvements

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.1.0 =
This update adds bookmarking functionality and automatic updates. Users can now save their favorite products using the bookmark icon.
