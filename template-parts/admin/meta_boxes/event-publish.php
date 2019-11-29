<div id="major-publishing-actions">

	<div id="publishing-action">
		<span class="spinner"></span>
		<label>
			<?php esc_html_e( 'Start', 'gatherpress' ); ?>
			<input type="date" name="gp_event_start_date" />
			<input type="time" name="gp_event_start_time" />
		</label>
		<label>
			<?php esc_html_e( 'End', 'gatherpress' ); ?>
			<input type="date" name="gp_event_end_date" />
			<input type="time" name="gp_event_end_time" />
		</label>
		<div class="clear"></div>
		<input type="submit" id="publish" name="publish" accesskey="p" value="Publish" class="button button-primary button-large" />
	</div>
	<div class="clear"></div>
</div>
