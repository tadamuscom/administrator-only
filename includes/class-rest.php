<?php
/**
 * Holds the Rest class
 *
 * @package administrator-only
 */

namespace Admon\Includes;

use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Rest' ) ) {
	/**
	 * Handle the redirection on the REST API
	 */
	class Rest {
		/**
		 * Construct the class
		 */
		public function __construct() {
			add_action( 'rest_api_init', array( $this, 'check_for_access' ) );
		}

		/**
		 * Check for access and redirect if needed
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function check_for_access(): void {
			if( $this->is_setting_enabled() ){
				if( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ){
					wp_redirect( get_option( 'admon_rest_api_link' ) );
					exit;
				}
			}
		}

		/**
		 * Check if the rest protection is enabled
		 *
		 * @since 1.0.0
		 *
		 * @return bool
		 */
		private function is_setting_enabled(): bool {
			$setting = get_option( 'admon_rest_api' );

			if( 'true' === $setting ){
				return true;
			}

			return false;
		}
	}

	new Rest();
}