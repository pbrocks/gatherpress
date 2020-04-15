<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Setup {

	use Singleton;

	/**
	 * Setup constructor.
	 */
	protected function __construct() {

		$this->_instantiate_classes();

	}

	/**
	 * Instantiate singletons.
	 */
	private function _instantiate_classes() : void {

		Assets::get_instance();
		BuddyPress::get_instance();
		Event::get_instance();
		Query::get_instance();

	}

}

// EOF
