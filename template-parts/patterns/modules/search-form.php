<?php
// This is a generated file. Refer to the relevant Twig file for adjusting this markup.
?>
<?php if ( ! empty( $search_form_is_swiftype ) ) { ?>
	<div data-st-search-form="small_search_form"></div>
<?php } else { ?>
	<form class="search-form <?php echo esc_attr( $search_form_classes ?? '' ); ?>" action="<?php echo esc_url( $search_form_action_url ?? '' ); ?>" role="search" method="get">
		<label class="">
			<span class="lrv-a-screen-reader-only">Search for:</span>
			<input class="<?php echo esc_attr( $search_form_input_classes ?? '' ); ?>" type="search" placeholder="<?php echo esc_attr( $search_form_input_placeholder_attr ?? '' ); ?>" value="" name="s">
		</label>
		<input class="<?php echo esc_attr( $search_form_submit_classes ?? '' ); ?>" type="submit" value="Search">
	</form>
<?php } ?>
