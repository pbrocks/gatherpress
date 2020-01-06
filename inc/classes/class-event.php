<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Event {

	use Singleton;

	const POST_TYPE    = 'gp_event';
	const NONCE_NAME   = 'gp_event_nonce';
	const NONCE_ACTION = 'gp_event_nonce_action';
	const CAPABILITY   = 'post_edit';
	const TABLE_FORMAT = '%s%s_extended';

	/**
	 * Event constructor.
	 */
	protected function __construct() {

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

//		if ( is_admin() ) {
//			add_action( 'load-post.php', [ $this, 'initialize_meta_box' ] );
//			add_action( 'load-post-new.php', [ $this, 'initialize_meta_box' ] );
//		}

		/**
		 * Filters.
		 */
		add_filter( 'wpmu_drop_tables', [ $this, 'on_site_delete' ] );
		add_filter( 'post_type_link', [ $this, 'append_post_id_to_url' ], 10, 2 );
		add_filter( 'block_editor_settings', [ $this, 'custom_editor_settings' ], 10, 2 );

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
			'events/([a-z-]+)-([0-9]+)?$',
			sprintf( 'index.php?post_type=%s&p=$matches[1]&postid=$matches[2]', static::POST_TYPE ),
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
					id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					post_id bigint(20) NOT NULL,
					datetime_start datetime NOT NULL,
					datetime_end datetime NOT NULL,
					KEY post_id (post_id)
				) {$charset_collate};";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $sql );

	}

	/**
	 * Initialize Event meta box.
	 * @todo remove
	 */
	public function initialize_meta_box() : void {

		add_action( 'add_meta_boxes', [ $this, 'change_publish_meta_box' ] );
		add_action( sprintf( 'save_post_%s', static::POST_TYPE ), [ $this, 'save_meta_box' ], 10, 2 );

	}

	/**
	 * Change meta box from Publish to Schedule with custom settings for events.
	 */
	public function change_publish_meta_box() : void {

		// Remove Publish meta box from Event post type.
		remove_meta_box( 'submitdiv', static::POST_TYPE, 'side' );

		add_meta_box( 'submitdiv', esc_html__( 'Schedule', 'gatherpress' ), [ $this, 'render_schedule_meta_box' ], static::POST_TYPE, 'side', 'high' );

	}

	/**
	 * Render the Schedule meta box.
	 *
	 * @param \WP_Post $post
	 * @param array    $args
	 */
	public function render_schedule_meta_box( \WP_Post $post, array $args ) : void {

		wp_nonce_field( static::NONCE_ACTION, static::NONCE_NAME );

		$submit_title = __( 'Schedule', 'gatherpress' );

		if ( 'auto-draft' !== $post->post_status ) {
			$submit_title = __( 'Update', 'gatherpress' );
		}

		echo Helper::render_template(
			GATHERPRESS_CORE_PATH . '/template-parts/admin/meta_boxes/event-schedule.php',
			[
				'post'         => $post,
				'args'         => $args,
				'submit_title' => $submit_title,
			]
		);

	}

	/**
	 * Save data from Schedule meta box.
	 *
	 * @param int      $post_id
	 * @param \WP_Post $post
	 */
	public function save_meta_box( int $post_id, \WP_Post $post ) : void {

		$nonce_value = sanitize_key( $_POST[ static::NONCE_NAME ] ?? '' );

		if ( ! wp_verify_nonce( $nonce_value, static::NONCE_ACTION ) ) {
			return;
		}

		if ( ! current_user_can( static::CAPABILITY, $post_id ) ) {
			return;
		}

		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		// @todo Save start and end date and time. Need to create a new table to JOIN on to query properly.

	}

	/**
	 * Register the Event post type.
	 */
	public function register_post_types() : void {

		register_post_type(
			static::POST_TYPE,
			[
				'labels'         => [
					'name'                => _x( 'Events', 'Post Type General Name', 'gatherpress' ),
					'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'gatherpress' ),
					'menu_name'           => __( 'Events', 'gatherpress' ),
					'all_items'           => __( 'All Events', 'gatherpress' ),
					'view_item'           => __( 'View Event', 'gatherpress' ),
					'add_new_item'        => __( 'Add New Event', 'gatherpress' ),
					'add_new'             => __( 'Add New', 'gatherpress' ),
					'edit_item'           => __( 'Edit Event', 'gatherpress' ),
					'update_item'         => __( 'Update Event', 'gatherpress' ),
					'search_items'        => __( 'Search Events', 'gatherpress' ),
					'not_found'           => __( 'Not Found', 'gatherpress' ),
					'not_found_in_trash'  => __( 'Not found in Trash', 'gatherpress' ),
				],
				'show_in_rest'  => true,
				'public'        => true,
				'hierarchical'  => false,
				'menu_position' => 3,
				'template_lock' => 'all',
				'template'      => $this->get_template(),
				'supports'      => [
					'title',
					'editor',
					'thumbnail',
					'comments',
					'revisions',
				],
				'menu_icon'     => 'dashicons-calendar',
			]
		);

	}

	public function get_template() {

		return [
			[
				'gatherpress/duration'
			],
			[
				'core/paragraph',
				[
					'placeholder' => __( 'Let everyone know what to expect, including the agenda, what they should bring, and how to find the group.', 'gatherpress' ),
				],
			],
		];

	}

	public function custom_editor_settings( $settings, $post ) {

		if ( static::POST_TYPE === $post->post_type ) {
			$settings['richEditingEnabled'] = true;
			$settings['codeEditingEnabled'] = false;
			$settings['titlePlaceholder'] = __( 'Event name', 'gatherpress' );
		}

		return $settings;

	}

}

//EOF
