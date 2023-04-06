<?php
/**
 * Plugin Name: Custom Product Tag Image
 *
 * Plugin URI: https://woocommerce.com/products/custom-product-tag-image/
 *
 * Description: Add images to your product tags and display them on product and archive pages.
 *
 * Version:1.1.0
 *
 * Author: KoalaApps
 *
 * Domain Path: /languages
 *
 * Author URI: http://www.koalaapps.net/
 *
 * Text Domain: koalaapps_tag
 *
 * Version: 1.0.0
 *
 * WC requires at least: 3.0.9
 *
 * WC tested up to: 5.*.*
 *
 * Woo: 6515948:821d8c82650de958c3da9e0a35fec915
 */

/**
 * Main class start.
 */
if ( ! defined( 'ABSPATH' ) ) {
		exit;
}
/**
 * Main product tag start.
 */
class Ka_Product_Tag_Main {
	/**
	 * Main constructer start.
	 */
	public function __construct() {

			$this->plugin_global_vars();
			// load Text Domain.
			add_action( 'wp_loaded', array( $this, 'menu_visibility_init' ) );
			// Include other Files.
		if ( is_admin() ) {
			// include Admin Class.
			require_once KPT_PLUGIN_DIR . 'class-ka-custom-image-tag.php';
		} else {
			// include front class.
			require_once KPT_PLUGIN_DIR . 'class-ka-custom-image-tag-front.php';
		}
	}
	/**
	 * Main function plugin global start.
	 */
	public function plugin_global_vars() {
		if ( ! defined( 'KPT_URL' ) ) {
			define( 'KPT_URL', plugin_dir_url( __FILE__ ) );
		}
		if ( ! defined( 'KPT_BASENAME' ) ) {
			define( 'KPT_BASENAME', plugin_basename( __FILE__ ) );
		}
		if ( ! defined( 'KPT_PLUGIN_DIR' ) ) {
			define( 'KPT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}
	}
	/**
	 * Main menu visibility function start.
	 */
	public function menu_visibility_init() {
		if ( function_exists( 'load_plugin_textdomain' ) ) {
				load_plugin_textdomain( 'koalaapps_tag', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}
	}
}
new KA_Product_Tag_Main();
