<div id="major-publishing-actions">

	<div id="date-time-action">
		<span class="spinner"></span>
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

	<div id="publishing-action">
		<input type="submit" id="publish" name="publish" accesskey="p" value="<?php echo esc_html( $submit_title ); ?>" class="button button-primary button-large" />
	</div>
	<div class="clear"></div>
</div>
