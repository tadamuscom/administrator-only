<?php
/**
 * Hold the helper functions
 *
 * @package administrator-only
 */

if ( ! function_exists( 'admon_maybe_add_option' ) ) {
	/**
	 * Add or edit an option
	 *
	 * @since 1.0.0
	 *
	 * @param string $name The name of the option.
	 * @param mixed  $value The value for the option.
	 *
	 * @package administrator-only
	 *
	 * @return void
	 */
	function admon_maybe_add_option( string $name, mixed $value ): void {
		if ( ! get_option( $name ) ) {
			add_option( $name, $value );
		} else {
			update_option( $name, $value );
		}
	}
}
