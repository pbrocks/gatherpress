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
		add_filter( 'posts_clauses', [ $this, 'order_past_events' ] );

	}

	public function get_upcoming_events() : \WP_Query {

		remove_filter( 'posts_clauses', [ $this, 'order_past_events' ] );
		add_filter( 'posts_clauses', [ $this, 'order_upcoming_events' ] );

		$args = [
			'post_type'      => Event::POST_TYPE,
			'no_found_rows'  => true,
			'posts_per_page' => 5,
		];

		$query = new \WP_Query( $args );

		remove_filter( 'posts_clauses', [ $this, 'order_upcoming_events' ] );
		add_filter( 'posts_clauses', [ $this, 'order_past_events' ] );

		return $query;

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
	 * Order events by start datetime for ones that happened in past.
	 *
	 * @todo this is how we will handle past events. Upcoming/current events need to have adjusted orderby.
	 *
	 * @param array $pieces
	 *
	 * @return array
	 */
	public function order_past_events( array $pieces ) : array {

		if ( ! is_archive() && ! is_home() ) {
			return $pieces;
		}

		global $wp_query, $wpdb;

		$event_table = $wpdb->prefix . 'gp_event_extended';

		if ( Event::POST_TYPE === $wp_query->get( 'post_type' ) ) {
			$current           = $this->get_current_datetime();

			$pieces['join']    = "LEFT JOIN {$event_table} ON {$wpdb->posts}.ID={$event_table}.post_id";
			$pieces['where']   .= $wpdb->prepare( " AND {$event_table}.datetime_end < %s", $current );
			$pieces['orderby'] = "{$event_table}.datetime_start DESC";
		}

		return $pieces;

	}

	public function order_upcoming_events( array $pieces ) : array {

		if ( ! is_archive() && ! is_home() ) {
			return $pieces;
		}

		global $wp_query, $wpdb;

		$event_table = $wpdb->prefix . 'gp_event_extended';

		if ( Event::POST_TYPE === $wp_query->get( 'post_type' ) ) {
			$current           = $this->get_current_datetime();

			$pieces['join']    = "LEFT JOIN {$event_table} ON {$wpdb->posts}.ID={$event_table}.post_id";
			$pieces['where']  .= $wpdb->prepare( " AND {$event_table}.datetime_end >= %s", $current );
			$pieces['orderby'] = "{$event_table}.datetime_start ASC";
		}

		return $pieces;

	}

	/**
	 * Get current datetime based on timezone if we have one set in WordPress.
	 *
	 * @return string
	 */
	public function get_current_datetime() : string {

		$server_timezone = date_default_timezone_get();
		$site_timezone   = wp_timezone_string();

		// If site timezone is a valid setting, set it for timezone.
		if ( ! preg_match( '/^-|\+/', $site_timezone ) ) {
			date_default_timezone_set( $site_timezone );
		}

		$current = date( 'Y-m-d H:i:s', time() );

		date_default_timezone_set( $server_timezone );

		return $current;

	}

}

// EOF
