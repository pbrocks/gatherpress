<?php
// This is a generated file. Refer to the relevant Twig file for adjusting this markup.
?>
<div class="header-sticky // u-max-width-100vw lrv-u-border-color-grey-light lrv-u-border-b-1 <?php echo esc_attr( $header_sticky_classes ?? '' ); ?>">

	<div class="lrv-u-flex lrv-u-align-items-center">

		<div class="u-border-lr-1@desktop lrv-u-border-color-grey">
			<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/objects/o-icon-button.php', $o_icon_button_menu, true ); ?>
		</div>

		<div class="lrv-u-overflow-auto lrv-u-flex u-flex-grow-1@desktop">
			<div class="lrv-u-align-items-center lrv-u-flex lrv-u-justify-content-center lrv-u-margin-l-1 lrv-u-padding-tb-050">

				<?php if ( ! empty( $main_menu ) ) { ?>
					<div class="a-hidden@desktop-xl-max">
						<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/modules/main-menu.php', $main_menu, true ); ?>
					</div>
				<?php } ?>

				<?php if ( ! empty( $read_next ) ) { ?>
					<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/modules/read-next.php', $read_next, true ); ?>
				<?php } ?>
			</div>
		</div>

		<div class="lrv-u-flex-shrink-0 u-margin-lr-auto@desktop-max u-flex-order-n1@desktop u-padding-lr-1@desktop lrv-u-flex lrv-u-align-items-center u-height-30 <?php echo esc_attr( $header_sticky_logo_classes ?? '' ); ?>">
			<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/components/c-logo.php', $c_logo, true ); ?>
		</div>

		<div class="a-hidden@desktop-max lrv-u-flex">
			<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/modules/header-subscribe-button.php', $header_subscribe_button, true ); ?>
		</div>

		<div class="lrv-u-margin-lr-1 lrv-u-flex lrv-u-align-items-center">
			<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/modules/expandable-search.php', $expandable_search_sticky, true ); ?>
		</div>

	</div>

</div>
