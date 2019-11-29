<?php
/**
 * Helper class
 */

namespace GatherPress\Inc;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Helper {

	public static function render_template( string $path, array $variables = [] ) {

		if ( ! file_exists( $path ) ) {
			return;
		}

		if ( ! empty( $variables ) ) {
			extract( $variables, EXTR_SKIP );
		}

		ob_start();

		require $path; // better to fail with an error than to continue with incorrect/weird data

		return ob_get_clean();

	}

}

//EOF
