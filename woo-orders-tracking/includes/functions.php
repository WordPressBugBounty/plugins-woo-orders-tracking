<?php
/**
 * Function include all files in folder
 *
 * @param $path   Directory address
 * @param $ext    array file extension what will include
 * @param $prefix string Class prefix
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! function_exists( 'vi_include_folder' ) ) {
	function vi_include_folder( $path, $prefix = '', $ext = array( 'php' ) ) {
		/*Include all files in payment folder*/
		if ( ! is_array( $ext ) ) {
			$ext = explode( ',', $ext );
			$ext = array_map( 'trim', $ext );
		}
		$sfiles = scandir( $path );
		foreach ( $sfiles as $sfile ) {
			if ( $sfile != '.' && $sfile != '..' ) {
				if ( is_file( $path . "/" . $sfile ) ) {
					$ext_file  = pathinfo( $path . "/" . $sfile );
					$file_name = $ext_file['filename'];
					if ( $ext_file['extension'] ) {
						if ( in_array( $ext_file['extension'], $ext ) ) {
							$class = preg_replace( '/\W/i', '_', $prefix . ucfirst( $file_name ) );

							if ( ! class_exists( $class ) ) {
								require_once $path . $sfile;
								if ( class_exists( $class ) ) {
									new $class;
								}
							}
						}
					}
				}
			}
		}
	}
}
if ( ! function_exists( 'vi_wot_set_time_limit' ) ) {
	function vi_wot_set_time_limit() {
		ActionScheduler_Compatibility::raise_memory_limit();
		wc_set_time_limit();
	}
}
if ( ! function_exists( 'vi_wot_json_decode' ) ) {
	function vi_wot_json_decode( $json, $assoc = true, $depth = 512, $options = 2 ) {
		if ( ! is_string( $json ) ) {
			return array();
		}
		if ( function_exists( 'mb_convert_encoding' ) ) {
			$json = mb_convert_encoding( $json, 'UTF-8', 'UTF-8' );
		}

		$decoded = json_decode( $json, $assoc, $depth, $options );

		return is_array( $decoded ) ? $decoded : array();
	}
}
if ( ! function_exists( 'vi_wot_hpos_enabled' ) ) {
	function vi_wot_hpos_enabled() {
		if ( is_callable( array( '\Automattic\WooCommerce\Utilities\OrderUtil', 'custom_orders_table_usage_is_enabled' ) ) ) {
			return \Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled();
		}

		return get_option( 'woocommerce_feature_custom_order_tables_enabled' ) === 'yes'
			|| get_option( 'woocommerce_custom_orders_table_enabled' ) === 'yes';
	}
}
if ( ! function_exists( 'vi_wot_json_encode' ) ) {
	function vi_wot_json_encode( $value, $options = 256, $depth = 512 ) {
		return wp_json_encode( $value, $options, $depth );
	}
}