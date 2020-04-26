<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Attendee {

	use Singleton;

	const TAXONOMY = 'gp_attendee';

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

		$parent_name = sprintf( 'attendee-%d', $post_id );
		$args        = [
			'slug' => $parent_name,
		];
		$children    = [
			'attending',
			'not-attending',
			'waitlist',
		];
		$parent_term = wp_insert_term( $parent_name, self::TAXONOMY, $args );

		if ( ! is_wp_error( $parent_term ) ) {
			foreach ( $children as $child ) {
				$child_name = sprintf( '%s-%s', $parent_name, $child );
				$args       = [
					'parent' => intval( $parent_term['term_id'] ),
					'slug'   => $child_name,
				];

				wp_insert_term( $child_name, self::TAXONOMY, $args );
			}
		}

	}

}

// EOF
