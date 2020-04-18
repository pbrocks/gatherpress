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
		add_filter( 'posts_clauses', [ $this, 'order_events_by_start_date' ] );

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
			$query->set( 'post_type', Event::POST_TYPE );
		}

	}

	/**
	 * Order events by start datetime.
	 *
	 * @param array $pieces
	 *
	 * @return array
	 */
	public function order_events_by_start_date( array $pieces ) : array {

		global $wp_query, $wpdb;

		$event_table = $wpdb->prefix . 'gp_event_extended';

		if ( Event::POST_TYPE === $wp_query->get( 'post_type' ) ) {
			$pieces['join']    = "LEFT JOIN {$event_table} ON {$wpdb->posts}.ID={$event_table}.post_id";
			$pieces['orderby'] = "{$event_table}.datetime_start ASC";
		}

		return $pieces;

	}

}

// EOF
