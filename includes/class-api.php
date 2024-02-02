<?php
/**
 * Holds the API class
 *
 * @package administrator-only
 */

namespace Admon\Includes;

use WP_REST_Request;

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

		/**
		 * Save the settings
		 *
		 * @since 1.0.0
		 *
		 * @param WP_REST_Request $request The request object.
		 *
		 * @return void
		 * @throws \Exception A regular exception.
		 */
		public function save_settings( WP_REST_Request $request ): void {
			$params = $request->get_params();

			$nonce = sanitize_text_field( $params['nonce'] );

			if ( ! empty( $nonce ) && wp_verify_nonce( $nonce, 'admon_settings' ) ) {
				$front_end          = sanitize_text_field( $params['front_end'] );
				$front_end_link     = sanitize_text_field( $params['front_end_link'] );
				$rest_api           = sanitize_text_field( $params['rest_api'] );
				$rest_api_link      = sanitize_text_field( $params['rest_api_link'] );
				$excluded_pages     = sanitize_text_field( $params['excluded_pages'] );

				if ( $front_end === 'on' ){
					if( empty( $front_end_link ) ){
						wp_send_json_error(
							array(
								'message' => __( 'The redirection link field cannot be empty', 'administrator-only' ),
							)
						);

						exit;
					}

					if( ! str_contains( $front_end_link, 'http' ) ){
						wp_send_json_error(
							array(
								'message' => __( 'The redirection address must be a valid link', 'administrator-only' ),
							)
						);

						exit;
					}

					admon_maybe_add_option( 'admon_front_end', 'true' );
				}else{
					admon_maybe_add_option( 'admon_front_end', 'false' );
				}

				if ( $rest_api === 'on' ){
					if( empty( $rest_api_link ) ){
						wp_send_json_error(
							array(
								'message' => __( 'The redirection link field cannot be empty', 'administrator-only' ),
							)
						);

						exit;
					}

					if( ! str_contains( $rest_api_link, 'http' ) ){
						wp_send_json_error(
							array(
								'message' => __( 'The redirection address must be a valid link', 'administrator-only' ),
							)
						);

						exit;
					}

					admon_maybe_add_option( 'admon_rest_api', 'true' );
				}else{
					admon_maybe_add_option( 'admon_rest_api', 'false' );
				}

				admon_maybe_add_option( 'admon_front_end_link', $front_end_link );
				admon_maybe_add_option( 'admon_rest_api_link', $rest_api_link );
				admon_maybe_add_option( 'admon_excluded_pages', $excluded_pages );

				wp_send_json_success(
					array(
						'message' => __( 'Settings Saved!', 'licensehub' ),
					)
				);

				exit;
			}
		}
	}

	new API();
}