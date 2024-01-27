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
 * Plugin URI:        https://tadamus.com/products/administrator-only
 * Description:       A very lightweight utility plugin that makes your site private to anyone but logged-in administrators. The only page that remains available to the public is the login page.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      8.0
 * Author:            Tadamus
 * Author URI:        https://tadamus.com
 * Text Domain:       administrator-only
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

class Administrator_Only{
	public function __construct() {
		add_action( 'template_redirect',  array( $this, 'check_for_access' ));
	}

	public function check_for_access() : void {
		$allowed_pages = array(
			'wp-login.php',
			'wp-admin'
		);

		if ( ! in_array( $GLOBALS['pagenow'], $allowed_pages ) && ! defined( 'REST_REQUEST' )  )  {
			if( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ){
				wp_redirect( 'https://tadamus.com' );
				exit;
			}
		}
	}
}

new Administrator_Only();