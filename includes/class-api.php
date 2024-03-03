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
	 * Handle all the API actions
	 */
	class API {
		/**
		 * The namespace
		 *
		 * @var string
		 */
		private string $namespace = 'tadamus/admon/v1';

		/**
		 * Construct the object
		 */
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
				$front_end      = sanitize_text_field( $params['front_end'] );
				$front_end_link = sanitize_text_field( $params['front_end_link'] );
				$rest_api       = sanitize_text_field( $params['rest_api'] );
				$rest_api_link  = sanitize_text_field( $params['rest_api_link'] );
				$excluded_pages = sanitize_text_field( $params['excluded_pages'] );
				$delete_all     = sanitize_text_field( $params['delete_all'] );

				if ( 'on' === $front_end ) {
					if ( empty( $front_end_link ) ) {
						wp_send_json_error(
							array(
								'message' => __( 'The redirection link field cannot be empty', 'administrator-only' ),
							)
						);

						exit;
					}

					if ( ! str_contains( $front_end_link, 'http' ) ) {
						wp_send_json_error(
							array(
								'message' => __( 'The redirection address must be a valid link', 'administrator-only' ),
							)
						);

						exit;
					}

					admon_maybe_add_option( 'admon_front_end', 'true' );
				} else {
					admon_maybe_add_option( 'admon_front_end', 'false' );
				}

				if ( 'on' === $rest_api ) {
					if ( empty( $rest_api_link ) ) {
						wp_send_json_error(
							array(
								'message' => __( 'The redirection link field cannot be empty', 'administrator-only' ),
							)
						);

						exit;
					}

					if ( ! str_contains( $rest_api_link, 'http' ) ) {
						wp_send_json_error(
							array(
								'message' => __( 'The redirection address must be a valid link', 'administrator-only' ),
							)
						);

						exit;
					}

					admon_maybe_add_option( 'admon_rest_api', 'true' );
				} else {
					admon_maybe_add_option( 'admon_rest_api', 'false' );
				}

				admon_maybe_add_option( 'admon_front_end_link', $front_end_link );
				admon_maybe_add_option( 'admon_rest_api_link', $rest_api_link );

				if ( ! empty( $excluded_pages ) ) {
					$pages = $this->set_excluded( $excluded_pages );

					foreach ( $pages as $page ) {
						if ( ! get_post( $page ) ) {
							// translators: The ID of the page that doesn't exist.
							$message = printf( esc_attr__( 'There is no page with the ID of %s', 'administrator-only' ), esc_attr( $page ) );

							wp_send_json_error(
								array(
									'message' => $message,
								)
							);
						}
					}

					admon_maybe_add_option( 'admon_excluded_pages', wp_json_encode( $pages ) );
				} else {
					admon_maybe_add_option( 'admon_excluded_pages', $excluded_pages );
				}

				if ( 'on' === $delete_all ) {
					admon_maybe_add_option( 'admon_delete_data', 'true' );
				} else {
					admon_maybe_add_option( 'admon_delete_data', 'false' );
				}

				/**
				 * Runs after the settings are saved
				 *
				 * It runs after the settings were saved.
				 *
				 * @since 1.0.0
				 */
				do_action( 'admon_saved_settings' );

				wp_send_json_success(
					array(
						'message' => __( 'Settings Saved!', 'administrator-only' ),
					)
				);

				exit;
			}
		}

		/**
		 * Sets the array of pages
		 *
		 * @since 1.0.0
		 *
		 * @param string $value The value of the WordPress Option that holds the pages.
		 *
		 * @return string[]
		 */
		private function set_excluded( string $value ): array {
			/**
			 * Run before the excluded pages setup
			 *
			 * Run before the pages array gets created.
			 *
			 * @since 1.0.0
			 */
			do_action( 'admon_before_set_excluded_pages' );

			$pages = array( $value );

			if ( str_contains( $value, ',' ) ) {
				$pages = explode( ',', trim( $value ) );
			}

			/**
			 * Run after the excluded pages setup
			 *
			 * Run after the pages array was created. But before the array is saved to the database
			 *
			 * @since 1.0.0
			 *
			 * @param string $pages Name of the option to update.
			 */
			do_action( 'admon_after_set_excluded_pages', array( $pages ) );

			return $pages;
		}
	}

	new API();
}
