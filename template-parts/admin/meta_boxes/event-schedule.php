<div class="inside">
	<div id="minor-publishing-actions">
		<div id="save-action">
			<input type="submit" name="save" id="save-post" value="<?php esc_attr_e( 'Save Draft', 'gatherpress' ); ?>" class="button" />
		</div>
		<div id="preview-action">
			<a class="preview button" href="<?php echo esc_url( get_preview_post_link( $post ) ); ?>" target="wp-preview-<?php echo (int) $post->ID; ?>" id="post-preview">
				<?php
				printf(
					'%1$s<span class="screen-reader-text"> %2$s</span>',
					esc_html__( 'Preview', 'gatherpress' ),
					esc_html__( '(opens in a new tab)', 'gatherpress' )
				);
				?>
			</a>
			<input type="hidden" name="wp-preview" id="wp-preview" value="" />
		</div>
		<div class="clear"></div>
	</div>

	<div id="misc-publishing-actions">
		<div class="misc-pub-section">
			<p>
				<label>
					<?php esc_html_e( 'Start', 'gatherpress' ); ?>
					<input type="date" name="gp_event_start_date" />
					<input type="time" name="gp_event_start_time" />
				</label>
			</p>
			<p>
				<label>
					<?php esc_html_e( 'End', 'gatherpress' ); ?>
					<input type="date" name="gp_event_end_date" />
					<input type="time" name="gp_event_end_time" />
				</label>
			</p>

		</div>
	</div>

	<div class="submitbox" id="submitpost">

		<div id="major-publishing-actions">
			<div id="publishing-action">
				<input type="submit" id="publish" name="publish" accesskey="p" value="<?php echo esc_html( $submit_title ); ?>" class="button button-primary button-large" />
			</div>
			<div class="clear"></div>
		</div>

	</div>
</div>
