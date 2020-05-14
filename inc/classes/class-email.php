<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Email {

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
//		add_action( 'wp', function() {
//			echo '<pre>';
//			print_r(Event::get_instance()->get_upcoming_events()); die;
//		});
//		$upcoming_events = Query::get_instance()->get_upcoming_events();
//		while ( $upcoming_events->have_posts() ) {
//			echo 'here ';
//			$upcoming_events->the_post();
//			print_r(get_the_ID() . ' ');
//		}
//		die;
	}

}

//EOF
