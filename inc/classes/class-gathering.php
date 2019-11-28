<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gathering {

	use Singleton;

	const POST_TYPE = 'gathering';

	protected function __construct() {

		$this->_setup_hooks();

	}

	protected function _setup_hooks() {

		add_action( 'init', [ $this, 'register_post_types' ] );

	}

	public function register_post_types() {

		register_post_type(
			static::POST_TYPE,
			[
				'labels'        => [
					'name'                => _x( 'Gatherings', 'Post Type General Name', 'gatherpress' ),
					'singular_name'       => _x( 'Gathering', 'Post Type Singular Name', 'gatherpress' ),
					'menu_name'           => __( 'Gatherings', 'gatherpress' ),
					'all_items'           => __( 'All Gatherings', 'gatherpress' ),
					'view_item'           => __( 'View Gathering', 'gatherpress' ),
					'add_new_item'        => __( 'Add New Gathering', 'gatherpress' ),
					'add_new'             => __( 'Add New', 'gatherpress' ),
					'edit_item'           => __( 'Edit Gathering', 'gatherpress' ),
					'update_item'         => __( 'Update Gathering', 'gatherpress' ),
					'search_items'        => __( 'Search Gatherings', 'gatherpress' ),
					'not_found'           => __( 'Not Found', 'gatherpress' ),
					'not_found_in_trash'  => __( 'Not found in Trash', 'gatherpress' ),
				],
				'public'       => true,
				'hierarchical' => false,
				'supports'     => [
					'title',
					'excerpt',
				],
				'menu_icon'    => 'dashicons-calendar',
			]
		);

	}

}

//EOF
