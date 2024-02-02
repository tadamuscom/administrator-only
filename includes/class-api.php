<?php
/**
 * Holds the API class
 *
 * @package administrator-only
 */

namespace Admon\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'API' ) ) {
	/**
	 * Responsible to load all the files in the plugin
	 */
	class API {
		/**
		 * The namespace
		 *
		 * @var string
		 */
		private string $namespace = 'tadamus/admon/v1';

		public function __construct() {
			add_action( 'rest_api_init', array( $this, 'api_routes' ) );
		}

		/**
		 * Register the routes
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function api_routes(): void {
			// Settings handler.
			register_rest_route(
				$this->namespace,
				'/settings',
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'save_settings' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				)
			);
		}

		public function save_settings(): void {
			wp_send_json_error( 'error one' );
		}
	}

	new API();
}