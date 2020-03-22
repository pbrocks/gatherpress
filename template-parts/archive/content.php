<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package gatherpress
 */

?>

<article class="col-md-4">
	<div class="card mb-4 shadow-sm">
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', [
				'alt' => the_title_attribute( [
					'echo' => false,
				] ),
				'class'=> 'card-img-top',
				'style' => 'height:auto',
			] );
			?>
		</a>
		<div class="card-body">
			<h5 class="card-title">Mon, May 18, 7:00pm</h5>
			<p class="card-text">
				<?php the_title(); ?>
			</p>
			<div class="d-flex justify-content-between align-items-center">
				<a href="<?php the_permalink(); ?>" type="button" class="btn btn-sm btn-outline-secondary">View</a>
			</div>
		</div>
	</div>
</article>
