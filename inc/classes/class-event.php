<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Event {

	use Singleton;

	const POST_TYPE = 'gp_event';

	const TABLE_FORMAT = '%s%s_extended';

	/**
	 * Event constructor.
	 */
	protected function __construct() {

		$this->rest_namespace = GATHERPRESS_REST_NAMESPACE . '/event';

		$this->_setup_hooks();

	}

	/**
	 * Setup hooks.
	 */
	protected function _setup_hooks() : void {

		/**
		 * Actions.
		 */
		add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'init', [ $this, 'change_rewrite_rule' ] );
		add_action( 'admin_init', [ $this, 'maybe_create_custom_table' ] );

		add_action( 'wp_insert_site', [ $this, 'on_site_create' ], 10, 1 );
		add_action( 'delete_post', [ $this, 'delete_event' ] );

		/**
		 * Filters.
		 */
		add_filter( 'wpmu_drop_tables', [ $this, 'on_site_delete' ] );
		add_filter( 'post_type_link', [ $this, 'append_post_id_to_url' ], 10, 2 );

	}

	/**
	 * Append Post ID to individual event URLs.
	 *
	 * @param string   $url
	 * @param \WP_Post $post
	 *
	 * @return string
	 */
	public function append_post_id_to_url( string $url, \WP_Post $post ) : string {

		if ( static::POST_TYPE === $post->post_type ) {
			return home_url( sprintf( 'events/%s-%d/', $post->post_name, $post->ID ) );
		}

		return $url;

	}

	/**
	 * Add new rewrite rule for event to append Post ID.
	 */
	public function change_rewrite_rule() : void {

		add_rewrite_rule(
			'^events/([^/]*)-([0-9]+)/?$',
			sprintf(
				'index.php?post_type=%s&postname=$matches[1]&p=$matches[2]',
				static::POST_TYPE
			),
			'top'
		);

	}

	/**
	 * Maybe create custom table if doesn't exist for main site or current site in network.
	 */
	public function maybe_create_custom_table() : void {

		$this->create_table();

		if ( is_multisite() ) {
			$blog_id = get_current_blog_id();

			switch_to_blog( $blog_id );
			$this->create_table();
			restore_current_blog();
		}

	}

	/**
	 * Create custom table on site creation.
	 *
	 * @param int $blog_id
	 */
	public function on_site_create( int $blog_id ) : void {

		switch_to_blog( $blog_id );
		$this->create_table();
		restore_current_blog();

	}

	/**
	 * Delete custom table on site deletion.
	 *
	 * @param array $tables
	 *
	 * @return array
	 */
	public function on_site_delete( array $tables ) : array {

		global $wpdb;

		$tables[] = sprintf( static::TABLE_FORMAT, $wpdb->prefix, static::POST_TYPE );

		return $tables;

	}

	/**
	 * Create custom event table.
	 */
	public function create_table() : void {

		global $wpdb;

		$sql             = [];
		$charset_collate = $GLOBALS['wpdb']->get_charset_collate();
		$table           = sprintf( static::TABLE_FORMAT, $wpdb->prefix, static::POST_TYPE );

		$sql[] = "CREATE TABLE {$table} (
					post_id bigint(20) NOT NULL PRIMARY KEY,
					datetime_start datetime NOT NULL,
					datetime_end datetime NOT NULL
				) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( $sql );

	}

	/**
	 * Register the Event post type.
	 */
	public function register_post_types() : void {

		register_post_type(
			static::POST_TYPE,
			[
				'labels'        => [
					'name'               => _x( 'Events', 'Post Type General Name', 'gatherpress' ),
					'singular_name'      => _x( 'Event', 'Post Type Singular Name', 'gatherpress' ),
					'menu_name'          => __( 'Events', 'gatherpress' ),
					'all_items'          => __( 'All Events', 'gatherpress' ),
					'view_item'          => __( 'View Event', 'gatherpress' ),
					'add_new_item'       => __( 'Add New Event', 'gatherpress' ),
					'add_new'            => __( 'Add New', 'gatherpress' ),
					'edit_item'          => __( 'Edit Event', 'gatherpress' ),
					'update_item'        => __( 'Update Event', 'gatherpress' ),
					'search_items'       => __( 'Search Events', 'gatherpress' ),
					'not_found'          => __( 'Not Found', 'gatherpress' ),
					'not_found_in_trash' => __( 'Not found in Trash', 'gatherpress' ),
				],
				'show_in_rest'  => true,
				'public'        => true,
				'hierarchical'  => false,
				'menu_position' => 3,
				'supports'      => [
					'title',
					'editor',
					'thumbnail',
					'comments',
					'revisions',
				],
				'menu_icon'     => 'dashicons-calendar',
				'rewrite'       => [
					'slug' => 'events',
				],
				'template_lock' => 'all',
				'template'      => [
					[
						'gatherpress/event-times',
						[
							'align' => 'left',
						],
					],
					[
						'core/paragraph',
						[
							'placeholder' => __( 'Let attendees know what they should expect. Include things like the agenda, what to bring, and how to find the group.', 'gatherpress' ),
						],
					],
				],
			]
		);

	}


	/**
	 * Delete event record from custom table when event is deleted.
	 *
	 * @param int $post_id
	 */
	public function delete_event( int $post_id ) : void {

		global $wpdb;

		$table = sprintf( static::TABLE_FORMAT, $wpdb->prefix, static::POST_TYPE );

		$wpdb->delete(
			$table,
			[
				'methods'  => \WP_REST_Server::READABLE,
				'callback' => [ $this, 'update_datetime' ],
				'args'     => [
					'_wpnonce'       => [
						/**
						 * WordPress will verify the nonce cookie, we just want to ensure nonce was passed as param.
						 *
						 * @see https://developer.wordpress.org/rest-api/using-the-rest-api/authentication/
						 */
						'required' => true,
					],
					'post_id'        => [
						'required'          => true,
						'validate_callback' => [ $this, 'validate_post_id' ],
					],
					'datetime_start' => [
						'required'          => true,
						'validate_callback' => [ $this, 'validate_datetime' ],
					],
					'datetime_end'   => [
						'required'          => true,
						'validate_callback' => [ $this, 'validate_datetime' ],
					],
				],
				'post_id'  => $post_id,
			]
		);

	}

	/**
	 * Get datetime start.
	 *
	 * @param int    $post_id
	 * @param string $format
	 *
	 * @return string
	 */
	public function get_datetime_start( int $post_id, string $format = 'D, F j, g:ia T' ) : string {

		return $this->_get_formatted_date( $post_id, $format, 'datetime_start' );

	}

	/**
	 * Get datetime end.
	 *
	 * @param int    $post_id
	 * @param string $format
	 *
	 * @return string
	 */
	public function get_datetime_end( int $post_id, string $format = 'D, F j, g:ia T' ) : string {

		return $this->_get_formatted_date( $post_id, $format, 'datetime_end' );

	}

	/**
	 * Format date for display.
	 *
	 * @param int    $post_id
	 * @param string $format
	 * @param string $which
	 *
	 * @return string
	 */
	protected function _get_formatted_date( int $post_id, string $format = 'D, F j, g:ia T', string $which = 'datetime_start' ) : string {

		$server_timezone = date_default_timezone_get();
		$site_timezone   = wp_timezone_string();

		// If site timezone is a valid setting, set it for timezone, if not remove `T` from format.
		if ( ! preg_match( '/^-|\+/', $site_timezone ) ) {
			date_default_timezone_set( $site_timezone );
		} else {
			$format = str_replace( ' T', '', $format );
		}

		$dt   = $this->get_datetime( $post_id );
		$date = $dt[ $which ];

		if ( ! empty( $date ) ) {
			$ts   = strtotime( $date );
			$date = date( $format, $ts );
		}

		date_default_timezone_set( $server_timezone );

		return (string) $date;

	}

	/**
	 * Get the datetime from custom table.
	 *
	 * @todo Add caching.
	 *
	 * @param int $post_id
	 *
	 * @return array
	 */
	public function get_datetime( int $post_id ) : array {

		global $wpdb;

		$table = sprintf( static::TABLE_FORMAT, $wpdb->prefix, static::POST_TYPE );
		$data  = (array) $wpdb->get_results( $wpdb->prepare( "SELECT datetime_start, datetime_end FROM {$table} WHERE post_id = %d LIMIT 1", $post_id ) );
		$data  = ( ! empty( $data ) ) ? (array) current( $data ) : [];

		return array_merge(
			[
				'datetime_start' => '',
				'datetime_end'   => '',
			],
			$data
		);

	}

}

// EOF
