<?php

namespace GatherPress\Inc;

use GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Attendee {

	use Singleton;

	const TABLE_FORMAT = '%sgp_attendees';

	public $statuses = [
		'attending',
		'not_attending',
		'waitlist',
	];

	// @todo temporary limit. Configuration coming in ticket https://github.com/mauteri/gatherpress/issues/56
	public $limit = 3;

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

		add_action( 'admin_init', [ $this, 'maybe_create_custom_table' ] );

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
	 * Create custom attendees table.
	 */
	public function create_table() : void {

		global $wpdb;

		$sql             = [];
		$charset_collate = $GLOBALS['wpdb']->get_charset_collate();
		$table           = sprintf( static::TABLE_FORMAT, $wpdb->prefix );

		$sql[] = "CREATE TABLE {$table} (
					id bigint(20) unsigned NOT NULL auto_increment,
					post_id bigint(20) unsigned NOT NULL default '0',
					user_id bigint(20) unsigned NOT NULL default '0',
					timestamp datetime NOT NULL default '0000-00-00 00:00:00',
					status varchar(255) default NULL,
					PRIMARY KEY  (id),
					KEY post_id (post_id),
					KEY user_id (user_id),
					KEY status (status)
				) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( $sql );

	}

	/**
	 * Get an event attendee.
	 *
	 * @param int $post_id
	 * @param int $user_id
	 *
	 * @return array
	 */
	public function get_attendee( int $post_id, int $user_id ) : array {

		global $wpdb;

		if ( 1 > $post_id || 1 > $user_id ) {
			return [];
		}

		$table       = sprintf( static::TABLE_FORMAT, $wpdb->prefix );
		$data        = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE post_id = %d AND user_id = %d", $post_id, $user_id ), ARRAY_A );

		return (array) $data;

	}

	/**
	 * Save an event attendee.
	 *
	 * @param int    $post_id
	 * @param int    $user_id
	 * @param string $status
	 *
	 * @return bool
	 */
	public function save_attendee( int $post_id, int $user_id, string $status ) : bool {

		global $wpdb;

		if ( 1 > $post_id || 1 > $user_id ) {
			return false;
		}

		$table    = sprintf( static::TABLE_FORMAT, $wpdb->prefix );
		$attendee = $this->get_attendee( $post_id, $user_id );

		if ( ! in_array( $status, $this->statuses, true ) ) {
			return false;
		}

		$data = [
			'post_id'   => intval( $post_id ),
			'user_id'   => intval( $user_id ),
			'timestamp' => date( 'Y-m-d H:i:s' ),
			'status'    => sanitize_key( $status ),
		];

		if ( ! empty( $attendee ) ) {
			if ( 1 > intval( $attendee['id'] ) ) {
				return false;
			}

			$where = [
				'id' => intval( $attendee['id'] ),
			];
			$save  = $wpdb->update( $table, $data, $where );
		} else {
			$save = $wpdb->insert( $table, $data );
		}

		return (bool) $save;

	}

	/**
	 * Get all attendees for an event.
	 *
	 * @todo adding caching to this method.
	 *
	 * @param int $post_id
	 *
	 * @return array
	 */
	public function get_attendees( int $post_id ) : array {

		global $wpdb;

		$return = [
			'all' => [
				'attendees' => [],
				'count'     => 0,
			],
		];

		if ( 1 > $post_id ) {
			return $return;
		}

		$site_users  = count_users();
		$total_users = $site_users['total_users'];
		$table       = sprintf( static::TABLE_FORMAT, $wpdb->prefix );
		$data        = (array) $wpdb->get_results( $wpdb->prepare( "SELECT user_id, timestamp, status FROM {$table} WHERE post_id = %d LIMIT %d", $post_id, $total_users ), ARRAY_A );
		$data        = ( ! empty( $data ) ) ? (array) $data : [];
		$attendees   = [];

		if ( empty( $data ) ) {
			return $return;
		}

		foreach ( $this->statuses as $status ) {
			$return[ $status ] = [
				'attendees' => [],
				'count'     => 0,
			];
		}

		foreach ( $data as $attendee ) {
			$user_id     = intval( $attendee['user_id'] );
			$user_status = sanitize_key( $attendee['status'] );

			if ( 1 > $user_id ) {
				continue;
			}

			if ( ! in_array( $user_status, $this->statuses, true ) ) {
				continue;
			}

			$user_info = get_userdata( $user_id );
			$roles     = Role::get_instance()->get_role_names();
			$attendees[] = [
				'id'      => $user_id,
				'name'    => $user_info->display_name,
				'photo'   => get_avatar_url( $user_id ),
				'profile' => bp_core_get_user_domain( $user_id ),
				'role'    => $roles[ current( $user_info->roles ) ] ?? '',
				'status'  => $user_status,
			];

		}

		// Sort before breaking down statuses in return array.
		usort( $attendees, [ $this, 'sort_attendees_by_role' ] );

		$return['all']['attendees'] = $attendees;
		$return['all']['count']     = count( $return['all']['attendees'] );

		foreach ( $this->statuses as $status ) {
			$return[ $status ]['attendees'] = array_filter( $attendees, function( $attendee ) use ( $status ) {
				return ( $status === $attendee['status'] );
			});

			$return[ $status ]['count'] = count( $return[ $status ]['attendees'] );
		}

		return $return;

	}

	/**
	 * Sort attendees by their role.
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return bool
	 */
	public function sort_attendees_by_role( $a, $b ) {

		$roles = array_values( Role::get_instance()->get_role_names() );

		return ( array_search( $a['role'], $roles ) > array_search( $b['role'], $roles ) );

	}

}

// EOF
