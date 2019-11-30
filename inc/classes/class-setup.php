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

		Event::get_instance();
		BuddyPress::get_instance();

	}

	protected function _setup_hooks() {

	}

}

//EOF
