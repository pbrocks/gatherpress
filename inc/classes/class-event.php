<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Event {

	use Singleton;

	const POST_TYPE = 'gp_event';

	protected function __construct() {

		$this->_setup_hooks();

	}

	protected function _setup_hooks() : void {

		add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'admin_init', [ $this, 'change_publish_meta_box' ] );

	}

	public function change_publish_meta_box() : void {

		remove_meta_box( 'submitdiv', static::POST_TYPE, 'side' );
		add_meta_box( 'submitdiv', esc_html__( 'Schedule', 'gatherpress' ), [ $this, 'publish_meta_box' ], static::POST_TYPE, 'side', 'high' );

	}

	public function publish_meta_box( $post, $args ) : void {
		$submit_title = __( 'Schedule', 'gatherpress' );

		if ( 'auto-draft' !== $post->post_status ) {
			$submit_title = __( 'Update', 'gatherpress' );
		}

		echo Helper::render_template(
			GATHERPRESS_CORE_PATH . '/template-parts/admin/meta_boxes/event-publish.php',
			[
				'post'         => $post,
				'args'         => $args,
				'submit_title' => $submit_title,
			]
		);

	}

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
			]
		);

	}

}

//EOF
