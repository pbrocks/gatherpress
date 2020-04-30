<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package gatherpress
 */

$event = GatherPress\Inc\Event::get_instance();
?>

<div class="bg-light p-md-5">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<div id="attendance_button_container" class="float-right"></div>
			<h3 class="h5">
				<?php echo esc_html( $event->get_datetime_start( get_the_ID(), 'l, F j, Y' ) ); ?>
			</h3>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<?php gatherpress_post_thumbnail(); ?>

		<div class="entry-content">
			<?php
			the_content();
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gatherpress' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php gatherpress_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div>

<nav>
	<div class="nav nav-tabs mb-4 mt-4" id="attendance-nav" role="tablist">
		<a class="nav-item nav-link active" id="nav-attending-tab" data-toggle="tab" href="#nav-attending" role="tab" aria-controls="nav-attending" aria-selected="true">
			<?php esc_html_e( 'Attending', 'gatherpress' ); ?>
		</a>
		<a class="nav-item nav-link" id="nav-waitlist-tab" data-toggle="tab" href="#nav-waitlist" role="tab" aria-controls="nav-waitlist" aria-selected="false">
			<?php esc_html_e( 'Waitlist', 'gatherpress' ); ?>
		</a>
		<a class="nav-item nav-link" id="nav-not-attending-tab" data-toggle="tab" href="#nav-not-attending" role="tab" aria-controls="nav-not-attending" aria-selected="false">
			<?php esc_html_e( 'Not Attending', 'gatherpress' ); ?>
		</a>
	</div>
</nav>
<div class="tab-content p-3" id="attendance-content">
	<div class="tab-pane fade show active" id="nav-attending" role="tabpanel" aria-labelledby="nav-attending-tab">
		Attending
	</div>
	<div class="tab-pane fade" id="nav-waitlist" role="tabpanel" aria-labelledby="nav-waitlist-tab">
		Waitlist
	</div>
	<div class="tab-pane fade" id="nav-not-attending" role="tabpanel" aria-labelledby="nav-not-attending-tab">
		Not Attending
	</div>
</div>
