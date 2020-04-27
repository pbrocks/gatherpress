const { __ }                         = wp.i18n;
const { registerPlugin }             = wp.plugins;
const { PluginDocumentSettingPanel } = wp.editPost;

import { Dropdown, Button, PanelRow } from '@wordpress/components';
import { DateTimeStart } from "./datetime-start";
import { DateTimeStartLabel } from "./datetime-start/label";
import { DateTimeEnd } from "./datetime-end";
import { DateTimeEndLabel } from "./datetime-end/label";
import apiFetch from '@wordpress/api-fetch';

const dateTimeFormat  = 'YYYY-MM-DThh:mm:ss';
const currentDateTime = moment().format( dateTimeFormat );

let dateTimeStart = GatherPress.event_datetime.datetime_start;
let dateTimeEnd   = GatherPress.event_datetime.datetime_end;

dateTimeStart = ( '' !== dateTimeStart ) ? moment( dateTimeStart ).format( dateTimeFormat ) : currentDateTime;
dateTimeEnd = ( '' !== dateTimeEnd ) ? moment( dateTimeEnd ).format( dateTimeFormat ) : currentDateTime;

GatherPress.event_datetime.datetime_start = dateTimeStart;
GatherPress.event_datetime.datetime_end   = dateTimeEnd;

// Checks if the post type is for events.
function isEventPostType() {
	const getPostType = wp.data.select( 'core/editor' ).getCurrentPostType(); // Gets the current post type.

	return ( getPostType === 'gp_event' );
}

function saveDateTime() {
	apiFetch(
		{
			path: '/gatherpress/v1/event/datetime/',
			method: 'POST',
			data: {
				post_id: GatherPress.post_id,
				datetime_start: moment( GatherPress.event_datetime.datetime_start ).format( 'YYYY-MM-DD HH:mm:ss' ),
				datetime_end: moment( GatherPress.event_datetime.datetime_end ).format( 'YYYY-MM-DD HH:mm:ss' ),
				_wpnonce: GatherPress.nonce,
			},
		}
	).then( ( res ) => {
		// Saved.
	} );
}

function updateDateTimeStart( date ) {
	GatherPress.event_datetime.datetime_start = date;

	saveDateTime();
}

function getDateTimeStart() {
	return GatherPress.event_datetime.datetime_start;
}

function updateDateTimeEnd( date ) {
	GatherPress.event_datetime.datetime_end = date;

	saveDateTime();
}

function getDateTimeEnd() {
	return GatherPress.event_datetime.datetime_end;
}

const DateAndTimeSettingPanel = () =>
	( isEventPostType() && (
		<PluginDocumentSettingPanel
			name        = 'datetime'
			title       = { __( 'Date & Time', 'gatherpress' ) }
			initialOpen = { true }
			className   = "datetime"
		>
			<PanelRow>
				<span>
					{ __( 'Start', 'gatherpress' ) }
				</span>
				<Dropdown
					position         = 'bottom left'
					contentClassName = 'edit-post-post-schedule__dialog'
					renderToggle     = { ( { onToggle, isOpen } ) => (
						<>
							<Button
								className     = 'edit-post-post-schedule__toggle'
								onClick       = { onToggle }
								aria-expanded = { isOpen }
								isLink
							>
								<DateTimeStartLabel
									date   = { getDateTimeStart() }
									isOpen = { isOpen }
								/>
							</Button>
						</>
					) }
					renderContent    = { () => <DateTimeStart
						updateDateTimeStart = { updateDateTimeStart }
					/> }
				/>
			</PanelRow>
			<PanelRow>
				<span>
					{ __( 'End', 'gatherpress' ) }
				</span>
				<Dropdown
					position         = 'bottom left'
					contentClassName = 'edit-post-post-schedule__dialog'
					renderToggle     = { ( { onToggle, isOpen } ) => (
						<>
							<Button
								className     = 'edit-post-post-schedule__toggle'
								onClick       = { onToggle }
								aria-expanded = { isOpen }
								isLink
							>
								<DateTimeEndLabel
									date   = { getDateTimeEnd() }
									isOpen = { isOpen }
								/>
							</Button>
						</>
					) }
					renderContent    = { () => <DateTimeEnd
						updateDateTimeEnd = { updateDateTimeEnd }
					/> }
				/>
			</PanelRow>
		</PluginDocumentSettingPanel>
	)
);

registerPlugin('date-and-time-setting-panel', {
	render: DateAndTimeSettingPanel,
	icon: ''
});
