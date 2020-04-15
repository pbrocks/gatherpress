<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BuddyPress {

	use Singleton;

	/**
	 * BuddyPress constructor.
	 */
	protected function __construct() {

		$this->_setup_hooks();

	}

	/**
	 * Setup hooks.
	 */
	protected function _setup_hooks() : void {

		if ( ! $this->is_buddypress_available() ) {
			add_action( 'admin_notices', [ $this, 'buddypress_dependency' ] );

			return;
		}

	}

	/**
	 * Warning message for BuddyPress dependency.
	 */
	public function buddypress_dependency() : void {

		printf(
			'<div class="error"><p>%s</p></div>',
			esc_html__( 'Warning: GatherPress requires the BuddyPress plugin to function.', 'gatherpress' )
		);

	}

	/**
	 * Check if BuddyPress is enabled.
	 *
	 * @return bool
	 */
	public function is_buddypress_available() : bool {

		return (bool) function_exists( 'buddypress' );

	}

}

//EOF
