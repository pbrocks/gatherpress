<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BuddyPress {

	use Singleton;

	protected function __construct() {

		$this->_setup_hooks();

	}

	protected function _setup_hooks() : void {

		if ( ! $this->is_buddypress_available() ) {
			add_action( 'admin_notices', [ $this, 'buddypress_dependency' ] );

			return;
		}

	}

	public function buddypress_dependency() {

		printf(
			'<div class="error"><p>%s</p></div>',
			esc_html__( 'Warning: GatherPress requires the BuddyPress plugin to function.', 'gatherpress' )
		);

	}

	public function is_buddypress_available() : bool {

		return (bool) function_exists( 'buddypress' );

	}

}

//EOF
