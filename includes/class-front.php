<?php
/**
 * Holds the Front class
 *
 * @package administrator-only
 */

namespace Admon\Includes;

if( ! class_exists( 'Front' ) ){
	/**
	 * Handles the protection on the front end pages
	 */
	class Front{
		/**
		 * Construct the class
		 */
		public function __construct() {
			add_action( 'template_redirect',  array( $this, 'check_for_access' ));
		}

		/**
		 * Check if the access should be restricted and redirect the user if they don't have access
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function check_for_access() : void {
			$allowed_pages = $this->get_allowed_pages();

			if( $this->is_setting_enabled() ){
				if ( ! in_array( $GLOBALS['pagenow'], $allowed_pages ) && ! defined( 'REST_REQUEST' )  )  {
					if( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ){
						wp_redirect( get_option( 'admon_front_end_link' ) );
						exit;
					}
				}
			}
		}

		/**
		 * Check if the front end protection is enabled
		 *
		 * @since 1.0.0
		 *
		 * @return bool
		 */
		private function is_setting_enabled(): bool {
			$setting = get_option( 'admon_front_end' );

			if( 'true' === $setting ){
				return true;
			}

			return false;
		}

		/**
		 * Return an array of the slugs of the allowed pages
		 *
		 * @since 1.0.0
		 *
		 * @return string[]
		 */
		private function get_allowed_pages(): array {
			$allowed_pages = array(
				'wp-login.php',
				'wp-admin'
			);

			$setting = get_option( 'admon_excluded_pages' );

			if( ! empty( $setting ) ){
				$pages = json_decode( $setting );

				foreach( $pages as $page ){
					$permalink = get_permalink( $page );

					if( $permalink ){
						$allowed_pages[] = $permalink;
					}
				}
			}

			return $allowed_pages;
		}
	}

	new Front();
}