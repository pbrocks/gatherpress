<?php
namespace GatherPress\Tests\Inc;

use GatherPress\Inc\Attendee;

class Test_Attendee extends \WP_UnitTestCase {

	public function test_save_attendee() {

		$instance = Attendee::get_instance();
		$post_id  = $this->factory->post->create(
			[
				'post_type' => 'gp_event'
			]
		);
		$user_id  = $this->factory->user->create();
		$status   = 'attending';

		$this->assertSame( $status, $instance->save_attendee( $post_id, $user_id, $status ) );

		$status = 'not_attending';
		$this->assertSame( $status, $instance->save_attendee( $post_id, $user_id, $status ) );

	}
}
