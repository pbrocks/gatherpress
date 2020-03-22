<?php
// This is a generated file. Refer to the relevant Twig file for adjusting this markup.
?>
<?php if ( ! empty( $header_logo_is_homepage ) ) { ?>
	<h1 class="lrv-u-flex">
<?php } ?>
	<a class="c-logo lrv-a-unstyle-link u-display-inline-flex lrv-u-width-100p <?php echo esc_attr( $c_logo_classes ?? '' ); ?>" href="<?php echo esc_url( $c_logo_url ?? '' ); ?>">
		<?php \PMC::render_template( CHILD_THEME_PATH . '/assets/build/svg/' . ( $c_logo_svg ?? '' ) . '.svg', [], true ); ?>
		<span class="lrv-a-screen-reader-only"><?php echo esc_html( $c_logo_screen_reader_text ?? '' ); ?></span>
	</a>
<?php if ( ! empty( $header_logo_is_homepage ) ) { ?>
	</h1>
<?php } ?>
