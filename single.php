<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package gatherpress
 */

get_header();
?>
<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div id="primary" class="content-area py-5">
				<main id="main" class="site-main container">
					<div class="bg-light p-md-5">
						<?php
						while ( have_posts() ) {
							the_post();

							get_template_part( 'template-parts/content', get_post_type() );
						?>
					</div>
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}

					} // End of the loop.
					?>
				</main><!-- #main -->
			</div><!-- #primary -->

		</div>
		<div class="col-md-3 mb-4 py-5">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php
get_footer();
