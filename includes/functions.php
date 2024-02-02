<?php

if( ! function_exists( 'admon_maybe_add_option' ) ){
	function admon_maybe_add_option( string $name, mixed $value ): void {
		if( ! get_option( $name ) ){
			add_option( $name, $value );
		}else{
			update_option( $name, $value );
		}
	}
}