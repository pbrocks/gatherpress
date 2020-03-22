<?php
/**
 * Helps instantiatet the Block Selector Panel.
 *
 * Currently also contains some diagnostic code.
 */
add_filter( 'render_block', 'show_the_block_constituents', 10, 2 );
/**
 * [show_the_block_constituents] Debug code for showing the parts of WP Blocks
 *
 * @param  [string] $block_content
 * @param  [array]  $block
 * @return [string]
 */
function show_the_block_constituents( $block_content, $block ) {
	if ( true === WP_DEBUG && current_user_can( 'administrator' ) ) {
		$block_content = "<div class='wp-block' data-blockType='{$block['blockName']}'>{$block_content}</div>" . ( 'string' === gettype( $block['blockName'] ) ? '<pre><xmp> $block_content = ' . gettype( $block_content ) . " {$block['blockName']} " . print_r( $block, true ) . '</xmp></pre>' : '' );
	}
	return $block_content;
}

/**
 * Adding a block category creates a Panel
 */
function create_gatherpress_blocks_panel( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'gatherpress',
				'title' => __( 'GatherPress Blocks Panel', 'gatherpress' ),
			),
		)
	);
}
add_filter( 'block_categories', 'create_gatherpress_blocks_panel', 10, 2 );

/**
 * Register our block and shortcode.
 */
function es5_block_init() {
	wp_register_script(
		'es5-block',
		get_template_directory_uri() . '/assets/src/js/blocks/es5-block/es5-block.js',
		array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ),
		filemtime( get_template_directory() . '/assets/src/js/blocks/es5-block/es5-block.js' )
	);

	// Register our block, and explicitly define the attributes we accept.
	register_block_type(
		'gatherpress/es5-block',
		array(
			'attributes'      => array(
				'text_one'     => array(
					'type' => 'string',
				),
				'text_two'     => array(
					'type' => 'string',
				),
				'textarea_one' => array(
					'type' => 'string',
				),
				'radio'        => array(
					'type' => 'string',
				),
			),
			'editor_script'   => 'es5-block',
			'render_callback' => 'es5_block_render',
		)
	);

	// Define our shortcode, too, using the same render function as the block.
	add_shortcode( 'es5_block', 'es5_block_render' );
}
add_action( 'init', 'es5_block_init' );

/**
 * Our combined block and shortcode renderer.
 *
 * For more complex shortcodes, this would naturally be a much bigger function, but
 * I've kept it brief for the sake of focussing on how to use it for block rendering.
 *
 * @param array $attributes The attributes that were set on the block or shortcode.
 */
function es5_block_render( $attributes ) {
	return '<h3>' . __FUNCTION__ . '</h3> <pre>' . print_r( $attributes, true ) . '</pre>';
}
