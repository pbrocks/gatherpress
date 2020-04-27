<?php
$event   = GatherPress\Inc\Event::get_instance();
$members = count_users()['total_users'];
$logo    = get_custom_logo();
?>
<section>

	<div class="media mb-4">
		<div class="media-image mr-3">
			<?php echo wp_kses_post( $logo ); ?>
		</div>
		<div class="media-body">
			<h3 class="mt-0">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				</a>
			</h3>
			<p>
				<?php echo esc_html( sprintf( _n( '%s Member', '%s Members', $members, 'gatherpress' ), $members ) ); ?>
			</p>
		</div>
	</div>
</section>
<section>
	<h4 class="h5">
		<?php echo esc_html( $event->get_display_datetime( get_the_ID() ) ); ?>
	</h4>
	<p>
		<a href="#"><?php echo esc_html_e( 'Add to calendar', 'gatherpress' ); ?></a>
	</p>
</section>
