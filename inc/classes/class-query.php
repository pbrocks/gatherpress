<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Query {

	use Singleton;

	/**
	 * Query constructor.
	 */
	protected function __construct() {

		$this->_setup_hooks();

	}

	/**
	 * Setup hooks.
	 */
	protected function _setup_hooks() : void {

		add_action( 'pre_get_posts', [ $this, 'pre_get_posts' ] );

	}

	/**
	 * Set post type query to event on homepage.
	 *
	 * @param $query
	 */
	public function pre_get_posts( $query ) : void {
		if (
			( $query->is_home() || $query->is_front_page() )
			&& $query->is_main_query()
		) {
			$query->set( 'post_type', 'gp_event' );
		}
	}

}

// EOF
