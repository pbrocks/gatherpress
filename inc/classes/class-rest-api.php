<?php

namespace GatherPress\Inc;

use \GatherPress\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rest_Api {

	use Singleton;

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

		add_action( 'rest_api_init', [ $this, 'register_endpoints' ] );

	}

	/**
	 * REST API endpoints for GatherPress events.
	 *
	 * @todo needs some current user can check.
	 */
	public function register_endpoints() {

		register_rest_route(
			sprintf( '%s/event', GATHERPRESS_REST_NAMESPACE ),
			'/datetime',
			[
				'methods'  => \WP_REST_Server::EDITABLE,
				'callback' => [ $this, 'update_datetime' ],
				'args'     => [
					'_wpnonce'       => [
						/**
						 * WordPress will verify the nonce cookie, we just want to ensure nonce was passed as param.
						 *
						 * @see https://developer.wordpress.org/rest-api/using-the-rest-api/authentication/
						 */
						'required'          => true,
					],
					'post_id'        => [
						'required'          => true,
						'validate_callback' => [ $this, 'validate_event_post_id' ],
					],
					'datetime_start' => [
						'required'          => true,
						'validate_callback' => [ $this, 'validate_datetime' ],
					],
					'datetime_end'   => [
						'required'          => true,
						'validate_callback' => [ $this, 'validate_datetime' ],
					],
				],
			]
		);

	}

	/**
	 * Validate Event Post ID.
	 *
	 * @param $param
	 *
	 * @return bool
	 */
	public function validate_event_post_id( $param ) : bool {

		return (
			0 < intval( $param )
			&& is_numeric( $param )
			&& Event::POST_TYPE === get_post_type( $param )
		);

	}

	/**
	 * Validate Datetime.
	 *
	 * @param $param
	 *
	 * @return bool
	 */
	public function validate_datetime( $param ) : bool {

		return (bool) \DateTime::createFromFormat( 'Y-m-d H:i:s', $param );

	}

	/**
	 * Update custom event table with start and end Datetime.
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return \WP_REST_Response
	 */
	public function update_datetime( \WP_REST_Request $request ) {

		global $wpdb;

		$params = wp_parse_args( $request->get_params(), $request->get_default_params() );
		$fields = array_filter( $params, function( $k ) {
			return in_array(
				$k,
				[
					'post_id',
					'datetime_start',
					'datetime_end',
				],
				true
			);
		}, ARRAY_FILTER_USE_KEY );
		$table  = sprintf( Event::TABLE_FORMAT, $wpdb->prefix, Event::POST_TYPE );
		$exists = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT post_id FROM ' . esc_sql( $table ) . ' WHERE post_id = %d',
				$fields['post_id']
			)
		);

		if ( ! empty( $exists ) ) {
			$success = $wpdb->update(
				$table,
				$fields,
				[ 'post_id' => $fields['post_id'] ]
			);

		} else {
			$success = $wpdb->insert( $table, $fields );
		}

		$response = [
			'success' => (bool) $success,
		];

		return new \WP_REST_Response( $response );

	}

}

// EOF
