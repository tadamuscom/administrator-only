<?php

/**
 * Holds the settings page class
 *
 * @package administrator-only
 */

namespace Admon\Includes\Pages\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( ! class_exists( 'Settings_Page' ) ){
	/**
	 * Handle the settings page
	 */
	class Settings_Page{
		/**
		 * Construct the object
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'menu_callback' ) );
		}

		/**
		 * Add the menu page
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function menu_callback() : void {
			add_management_page( 'Administrator Only', 'Administrator Only', 'manage_options', 'administrator-only', array( $this, 'page_callback' ) );
		}

		/**
		 * Add the interface for the settings page
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function page_callback() : void {
			wp_enqueue_style( 'admon-settings-page', ADMON_CSS . '/admin/main.css', array(), ADMON_VERSION );
			wp_enqueue_script(
				'admon-settings-page',
				ADMON_PAGES . '/settings/js/build/index.js',
				array(
					'wp-i18n',
					'wp-element',
					'wp-api-fetch',
				),
				ADMON_VERSION
			);

			wp_localize_script(
				'admon-settings-page',
				'admon_settings',
				array(
					'logo'              => ADMON_IMG . '/tadamus-logo.png',
					'nonce'             => wp_create_nonce( 'admon_settings' ),
					'front_end'         => esc_attr( get_option( 'admon_front_end' ) ),
					'front_end_link'    => esc_attr( get_option( 'admon_front_end_link' ) ),
					'rest_api'          => esc_attr( get_option( 'admon_rest_api' ) ),
					'rest_api_link'     => esc_attr( get_option( 'admon_rest_api_link' ) ),
					'excluded_pages'    => esc_attr( get_option( 'admon_excluded_pages' ) )
				)
			);

			remove_all_actions( 'admin_notices' );

			echo '<div id="settings-root"></div>';
		}
	}

	new Settings_Page();
}