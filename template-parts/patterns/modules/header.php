<?php
// This is a generated file. Refer to the relevant Twig file for adjusting this markup.
?>
<header class="header // js-Header <?php echo esc_attr( $header_classes ?? '' ); ?>">
	<div class="js-Header-contents lrv-u-flex lrv-u-justify-content-space-between a-stacking-context a-stack-1">
		<div class="js-hide-when-sticky lrv-u-width-100p lrv-u-padding-tb-1 <?php echo esc_attr( $header_contents_classes ?? '' ); ?>">
			<div class="lrv-a-wrapper">
				<div class="lrv-a-grid lrv-a-cols3@desktop lrv-u-align-items-center a-grid-gap-0">
					<div class="lrv-u-flex lrv-a-space-children-horizontal lrv-a-space-children--2 lrv-u-align-items-center">
						<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/components/c-link.php', $c_link, true ); ?>
					</div>
					<div class="lrv-u-text-align-center">
						<div class="lrv-u-flex u-align-items-flex-end">
							<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/components/c-logo.php', $c_logo, true ); ?>
						</div>
					</div>
				</div>
				<div class="lrv-u-align-items-center lrv-u-flex lrv-u-justify-content-center lrv-u-margin-t-1">
					<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/objects/o-icon-button.php', $o_icon_button_menu, true ); ?>
				</div>
			</div>
		</div>

		<div class="js-show-when-sticky lrv-u-width-100p js-sticky-header-slidedown">
			<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/modules/header-sticky.php', $header_sticky, true ); ?>
		</div>
	</div>
</header>
