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

wp.data.subscribe( saveDateTime );

let dateTimeStart = GatherPress.event_datetime.datetime_start;
let dateTimeEnd   = GatherPress.event_datetime.datetime_end;

dateTimeStart = ( '' !== dateTimeStart ) ? moment( dateTimeStart ).format( dateTimeFormat ) : currentDateTime;
dateTimeEnd = ( '' !== dateTimeEnd ) ? moment( dateTimeEnd ).format( dateTimeFormat ) : moment( currentDateTime ).add( 2, 'hours' ).format( dateTimeFormat );

GatherPress.event_datetime.datetime_start = dateTimeStart;
GatherPress.event_datetime.datetime_end   = dateTimeEnd;

// Checks if the post type is for events.
function isEventPostType() {
	const getPostType = wp.data.select( 'core/editor' ).getCurrentPostType(); // Gets the current post type.

	return ( getPostType === 'gp_event' );
}

// @todo maybe put this is a save_post hook.
// https://www.ibenic.com/use-wordpress-hooks-package-javascript-apps/
// Then move button enabler
function saveDateTime() {
	let isSavingPost     = wp.data.select( 'core/editor' ).isSavingPost(),
		isAutosavingPost = wp.data.select( 'core/editor' ).isAutosavingPost();

	if ( isSavingPost && ! isAutosavingPost ) {
		apiFetch(
			{
				path: '/gatherpress/v1/event/datetime/',
				method: 'POST',
				data: {
					post_id: GatherPress.post_id,
					datetime_start: moment(GatherPress.event_datetime.datetime_start).format('YYYY-MM-DD HH:mm:ss'),
					datetime_end: moment(GatherPress.event_datetime.datetime_end).format('YYYY-MM-DD HH:mm:ss'),
					_wpnonce: GatherPress.nonce,
				},
			}
		).then((res) => {
			// Saved.
		});
	}
}

// @todo hack approach to enabling Save buttons after update
// https://github.com/WordPress/gutenberg/issues/13774
function enableSave() {
	wp.data.dispatch( 'core/editor' ).editPost( { meta: { _non_existing_meta: true } } );
}

function updateDateTimeStart( date, setState ) {
	GatherPress.event_datetime.datetime_start = date;
	setState( { date } );
	enableSave();
}

function getDateTimeStart() {
	return GatherPress.event_datetime.datetime_start;
}

function updateDateTimeEnd( date, setState ) {
	GatherPress.event_datetime.datetime_end = date;
	setState( { date } );
	enableSave();
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
			className   = 'datetime'
		>
			<PanelRow>
				<span>
					{ __( 'Start', 'gatherpress' ) }
				</span>
				<Dropdown
					position         = 'bottom left'
					renderToggle     = { ( { isOpen, onToggle } ) => (
						<Button
							onClick       = { onToggle }
							aria-expanded = { isOpen }
							isLink
						>
							<DateTimeStartLabel
								date   = { getDateTimeStart() }
							/>
						</Button>
					) }
					renderContent    = { () => <DateTimeStart
						updateDateTimeStart = { updateDateTimeStart }
						getDateTimeStart    = { getDateTimeStart }
					/> }
				/>
			</PanelRow>
			<PanelRow>
				<span>
					{ __( 'End', 'gatherpress' ) }
				</span>
				<Dropdown
					position         = 'bottom left'
					renderToggle     = { ( { isOpen, onToggle } ) => (
						<Button
							onClick       = { onToggle }
							aria-expanded = { isOpen }
							isLink
						>
							<DateTimeEndLabel
								date   = { getDateTimeEnd() }
							/>
						</Button>
					) }
					renderContent    = { () => <DateTimeEnd
						updateDateTimeEnd = { updateDateTimeEnd }
						getDateTimeEnd    = { getDateTimeEnd }
					/> }
				/>
			</PanelRow>
		</PluginDocumentSettingPanel>
	)
);

registerPlugin( 'date-and-time-setting-panel', {
	render: DateAndTimeSettingPanel,
	icon: ''
} );
