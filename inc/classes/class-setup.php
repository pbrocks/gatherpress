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

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

	}

	public function enqueue_scripts() {

		wp_enqueue_style( 'gatherpress-main', GATHERPRESS_CORE_URL . '/assets/build/css/main.css' );

	}

	public function admin_enqueue_scripts() {

		wp_enqueue_style( 'gatherpress-admin', GATHERPRESS_CORE_URL . '/assets/build/css/admin.css' );

	}

}

//EOF
