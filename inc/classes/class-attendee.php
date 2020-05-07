<?php

namespace GatherPress\Inc;

use GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Attendee {

	use Singleton;

	const TABLE_FORMAT = '%sgp_attendees';

	var $statuses = [
		'attending',
		'not-attending',
		'waitlist',
	];

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
	 * @param int $post_id
	 *
	 * @return array
	 */
	public function get_attendees( int $post_id ) : array {

		global $wpdb;

		$site_users  = count_users();
		$total_users = $site_users['total_users'];
		$table       = sprintf( static::TABLE_FORMAT, $wpdb->prefix );
		$data        = (array) $wpdb->get_results( $wpdb->prepare( "SELECT user_id, timestamp, status FROM {$table} WHERE post_id = %d LIMIT %d", $post_id, $total_users ), ARRAY_A );
		$data        = ( ! empty( $data ) ) ? (array) $data : [];
		$users       = [];

		if ( empty( $data ) ) {
			return $users;
		}

		foreach ( $data as $user ) {
			$user_id = intval( $user['user_id'] );

			if ( 1 > $user_id ) {
				continue;
			}

			$user_info = get_userdata( $user_id );
			$roles     = Role::get_instance()->get_role_names();

			$users[] = [
				'id'      => $user_id,
				'name'    => $user_info->display_name,
				'photo'   => get_avatar_url( $user_id ),
				'profile' => bp_core_get_user_domain( $user_id ),
				'role'    => $roles[ current( $user_info->roles ) ] ?? '',
				'status'  => sanitize_key( $user['status'] ),
			];

		}

		usort( $users, [ $this, 'sort_attendees_by_role' ] );

		return $users;

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
