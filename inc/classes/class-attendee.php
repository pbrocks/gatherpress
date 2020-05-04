<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Attendee {

	use Singleton;

	const TAXONOMY  = 'gp_attendee';
	const TERM_SLUG = 'attendee-%d';

	private $_term_children = [
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

		add_action( 'init', [ $this, 'register_taxonomy' ] );
		add_action( sprintf( 'save_post_%s', Event::POST_TYPE ), [ $this, 'save_event' ] );

	}

	public function get_term_children() : array {

		return $this->_term_children;

	}

	public function register_taxonomy() : void {

		$args = [
			'hierarchical'       => true,
			'public'             => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_quick_edit' => false,
			'meta_box_cb'        => false,
			'show_in_nav_menus'  => false,
			'show_in_tag_cloud'  => false,
			'show_in_quick_edit' => false,
		];

		register_taxonomy( self::TAXONOMY, 'user', $args );

	}

	public function save_event( $post_id ) : void {

		$parent_name = sprintf( self::TERM_SLUG, $post_id );
		$args        = [
			'slug' => $parent_name,
		];
		$parent_term = wp_insert_term( $parent_name, self::TAXONOMY, $args );

		if ( ! is_wp_error( $parent_term ) ) {
			foreach ( $this->get_term_children() as $child ) {
				$child_name = sprintf( '%s-%s', $parent_name, $child );
				$args       = [
					'parent' => intval( $parent_term['term_id'] ),
					'slug'   => $child_name,
				];

				wp_insert_term( $child_name, self::TAXONOMY, $args );
			}
		}

	}

	public function get_attendees( int $post_id ) : array {

		$slug = sprintf( self::TERM_SLUG, $post_id );
		$term = get_term_by( 'slug', $slug, self::TAXONOMY );

		if ( ! is_a( $term, '\WP_Term' ) ) {
			return [];
		}

		$user_ids = get_objects_in_term(
			$term->term_id,
			Attendee::TAXONOMY
		);
		$users    = [];
		$statuses = [];

		foreach ( $this->get_term_children() as $status ) {
			$statuses[ $status ] = get_term_by(
				'slug',
				sprintf( '%s-%s', $slug, $status ),
				self::TAXONOMY,
				ARRAY_A
			);

			if ( ! is_array ( $statuses[ $status ] ) ) {
				$statuses[ $status ] = [];
				continue;
			}

			$statuses[ $status ]['user_ids'] = get_objects_in_term(
				$statuses[ $status ]['term_id'],
				Attendee::TAXONOMY
			);
		}

		foreach ( $user_ids as $user_id ) {
			$user_info = get_userdata( $user_id );
			$roles     = Role::get_instance()->get_role_names();

			$user = [
				'id'      => $user_id,
				'name'    => $user_info->display_name,
				'photo'   => get_avatar_url( $user_id ),
				'profile' => bp_core_get_user_domain( $user_id ),
				'role'    => $roles[ current( $user_info->roles ) ] ?? '',
				'status'  => [],
			];

			foreach ( $this->get_term_children() as $status ) {
				if (
					empty( $statuses[ $status ]['user_ids'] )
					|| ! is_array( $statuses[ $status ]['user_ids'] )
				) {
					$statuses[ $status ]['user_ids'] = [];
				}

				$user['status'][ $status ] = in_array( $user_id, $statuses[ $status ]['user_ids'], true );
			}

			$users[] = $user;
		}

		usort( $users, [ $this, 'sort_users_by_role' ] );

		return $users;

	}

	public function sort_users_by_role( $a, $b ) {

		$roles = array_values( Role::get_instance()->get_role_names() );

		return ( array_search( $a['role'], $roles ) > array_search( $b['role'], $roles ) );

	}

	public function user_event_status( int $post_id, int $user_id = 0 ) : array {

		$status = [];

		if ( ! intval( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		if ( ! intval( $user_id ) ) {
			return $status;
		}

		$slug = sprintf( self::TERM_SLUG, $post_id );

		$has_parent = is_object_in_term( $user_id, self::TAXONOMY, $slug );

		if ( is_wp_error( $has_parent ) || ! $has_parent ) {
			return $status;
		}

		foreach ( $this->get_term_children() as $value ) {
			$has_value = is_object_in_term( $user_id, self::TAXONOMY, sprintf( '%s-%s', $slug, $value ) );
			if ( ! is_wp_error( $has_value ) && $has_value ) {
				$status[] = sanitize_key( $value );
			}
		}

		return (array) $status;

	}

}

// EOF
