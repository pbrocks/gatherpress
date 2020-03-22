<?php
// This is a generated file. Refer to the relevant Twig file for adjusting this markup.
?>
<div class="expandable-search // js-ExpandableSearch lrv-u-flex">

	<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/objects/o-icon-button.php', $o_icon_button_search, true ); ?>

	<div class="expandable-search__target // js-ExpandableSearch-target lrv-a-unstyle-button lrv-u-color-black js-fade js-fade-is-out <?php echo esc_attr( $expandable_search_classes ?? '' ); ?>" hidden>
		<div class="expandable_search__inner <?php echo esc_attr( $expandable_search_inner_classes ?? '' ); ?>" data-header-search-trigger="">
			<?php \PMC::render_template( CHILD_THEME_PATH . '/template-parts/patterns/modules/search-form.php', $search_form, true ); ?>
		</div>
	</div>

</div>
