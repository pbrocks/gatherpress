<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Assets {

	use Singleton;

	protected $_build = GATHERPRESS_CORE_URL . '/assets/build/';

	/**
	 * Assets constructor.
	 */
	protected function __construct() {

		$this->_setup_hooks();

	}

	/**
	 * Setup hooks.
	 */
	protected function _setup_hooks() : void {

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'block_enqueue_scripts' ] );

	}

	/**
	 * Enqueue frontend styles and scripts.
	 */
	public function enqueue_scripts() : void {

		wp_enqueue_style( 'gatherpress-style-css',  $this->_build . 'style.css', [], GATHERPRESS_THEME_VERSION );

		wp_enqueue_style( 'gatherpress-bootstrap-css', $this->_build . 'bootstrap_css.css', [], GATHERPRESS_THEME_VERSION );

		wp_enqueue_script( 'gatherpress-bootstrap-js', $this->_build . 'bootstrap_js.js', [ 'jquery' ], GATHERPRESS_THEME_VERSION, true );

	}

	/**
	 * Enqueue backend styles and scripts.
	 */
	public function admin_enqueue_scripts() : void {

		wp_enqueue_style( 'gatherpress-admin-css', $this->_build . 'admin.css', [], GATHERPRESS_THEME_VERSION );

	}

	/**
	 * Enqueue block styles and scripts.
	 */
	public function block_enqueue_scripts() : void {

		wp_enqueue_style( 'gatherpress-editor-css', $this->_build . 'editor.css', [ 'wp-edit-blocks' ], GATHERPRESS_THEME_VERSION );

		wp_enqueue_script(
			'gatherpress-index-js',
			$this->_build . 'index.js',
			[
				'wp-blocks',
				'wp-i18n',
				'wp-element',
				'wp-plugins',
				'wp-edit-post',
			],
			GATHERPRESS_THEME_VERSION
		);

	}

}

// EOF
