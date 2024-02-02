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
	class Settings_Page{
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'menu_callback' ) );
		}

		public function menu_callback() : void {
			add_management_page( 'Administrator Only', 'Administrator Only', 'manage_options', 'administrator-only', array( $this, 'page_callback' ) );
		}

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
					'logo'  => ADMON_IMG . '/tadamus-logo.png',
					'nonce' => wp_create_nonce( 'admon_settings' )
				)
			);

			echo '<div id="settings-root"></div>';
		}
	}

	new Settings_Page();
}