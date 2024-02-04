<?php
/**
 * Administrator Only
 *
 * @package           administrator-only
 * @author            Tadamus
 * @copyright         2024 Tadamus
 * @license           GPL-2.0-or-later
 *
 * @administrator-only
 * Plugin Name:       Administrator Only
 * Plugin URI:        https://github.com/tadamuscom/administrator-only
 * Description:       A very lightweight utility plugin that makes your site private to anyone but logged-in administrators. The only pages that remain available to the public are the login page and any other page of your choosing.
 * Version:           1.0.0
 * Requires at least: 6.2
 * Requires PHP:      8.0
 * Author:            Tadamus
 * Author URI:        https://tadamus.com
 * Text Domain:       administrator-only
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace Admon;

define( 'ADMON_VERSION', '1.0.0' );

if ( ! defined( 'ADMON_SLUG' ) ) {
	define( 'ADMON_SLUG', 'administrator-only' );
}

if ( ! defined( 'ADMON_PATH' ) ) {
	define( 'ADMON_PATH', WP_PLUGIN_DIR . '/' . ADMON_SLUG );
}

if ( ! defined( 'ADMON_INC' ) ) {
	define( 'ADMON_INC', ADMON_PATH . '/includes' );
}

if ( ! defined( 'ADMON_URL' ) ) {
	define( 'ADMON_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'ADMON_PAGE' ) ) {
	define( 'ADMON_PAGES', ADMON_URL . 'includes/pages' );
}

if ( ! defined( 'ADMON_ASSET' ) ) {
	define( 'ADMON_ASSET', ADMON_URL . '/assets' );
}

if ( ! defined( 'ADMON_CSS' ) ) {
	define( 'ADMON_CSS', ADMON_ASSET . '/css' );
}

if ( ! defined( 'ADMON_IMG' ) ) {
	define( 'ADMON_IMG', ADMON_ASSET . '/img' );
}

/**
 * The main class of the plugin.
 */
class Administrator_Only {
	/**
	 * Initiate the class
	 */
	public function __construct() {
		require_once ADMON_INC . '/class-loader.php';

		add_action( 'deactivate_' . ADMON_SLUG . '/class-' . ADMON_SLUG . '.php', array( $this, 'deactivate' ) );
	}

	/**
	 * Run actions on deactivation
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function deactivate(): void {
		if ( 'true' === get_option( 'admon_delete_data' ) ) {
			delete_option( 'admon_front_end' );
			delete_option( 'admon_front_end_link' );
			delete_option( 'admon_rest_api' );
			delete_option( 'admon_rest_api_link' );
			delete_option( 'admon_excluded_pages' );
			delete_option( 'admon_delete_data' );
		}

		/**
		 * Deactivation hook.
		 *
		 * Runs when the plugin gets deactivated after the default code for the deactivation.
		 *
		 * @since 1.0.0
		 */
		do_action( 'admon_deactivation' );
	}
}

new Administrator_Only();
