<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package gatherpress
 */

?>

		</div><!-- #content -->

		<footer id="colophon" class="site-footer bg-dark text-white mt-4">
			<div class="container-fluid py-3">
				<div class="row">
					<div class="col-md-6 small">
						<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'gatherpress' ) ); ?>">
							<?php
							esc_html_e( 'Proudly powered by WordPress', 'gatherpress' );
							?>
						</a>
					</div>
					<div class="col-md-6 text-right small align-self-end">
						<?php
						printf( esc_html__( 'Copyright &copy; %d GatherPress. All rights reserved.', 'gatherpress' ), date( 'Y' ) );
						?>
					</div>
				</div>
			</div>
		</footer>
	</div><!-- #page -->

	<?php wp_footer(); ?>

	</body>
</html>
