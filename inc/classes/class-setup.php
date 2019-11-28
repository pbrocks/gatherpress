<?php
/**
 * Setup GatherPress theme.
 */
 namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Setup {

	use Singleton;

	protected function __construct() {

		$this->_instantiate_classes();
		$this->_setup_hooks();

	}

	private function _instantiate_classes() {

		Gathering::get_instance();

	}

	protected function _setup_hooks() {

		add_action( 'admin_notices', [ $this, 'buddypress_dependency' ] );

	}

	public function buddypress_dependency() {

		if ( ! function_exists( 'buddypress' ) ) {
			printf(
				'<div class="error"><p>%s</p></div>',
				esc_html__( 'Warning: GatherPress requires the BuddyPress plugin to function.', 'gatherpress' )
			);
		}

	}

}

//EOF
