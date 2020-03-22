<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function gather_blocks_editor_assets() {
	$url = get_template_directory_uri() . '/pbrocks';

	wp_enqueue_script(
		'gather-blocks-js',
		$url . '/build/index.js',
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-plugins',
			'wp-edit-post',
		)
	);

	wp_enqueue_style(
		'gather-blocks-editor-css',
		$url . '/build/editor.css',
		array( 'wp-edit-blocks' )
	);
}

add_action( 'enqueue_block_editor_assets', 'gather_blocks_editor_assets' );

/**
 * [gather_blocks_assets] Hook assets into the editor.
 *
 * @return [type] [description]
 */
function gather_blocks_assets() {
	$url = get_template_directory_uri() . '/pbrocks';

	wp_enqueue_style(
		'gather-blocks-frontend-css',
		$url . '/build/style.css'
	);
}

add_action( 'enqueue_block_assets', 'gather_blocks_assets' );
