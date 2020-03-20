import React from 'react';
const { __ } = wp.i18n;
const { SelectControl, Dropdown, Button, BaseControl, TextControl, DateTimePicker, Panel, PanelBody, PanelRow,  } = wp.components;
const { PluginDocumentSettingPanel } = wp.editPost;
const { registerPlugin } = wp.plugins;
import { DateTimeStart } from "./datetime-start";
import { DateTimeStartLabel } from "./datetime-start/label";
import { DateTimeEnd } from "./datetime-end";
import { DateTimeEndLabel } from "./datetime-end/label";

// Checks if the post type is for events.
function isEventPostType() {
	const getPostType = wp.data.select( 'core/editor' ).getCurrentPostType(); // Gets the current post type.

	return ( getPostType === 'gp_event' );
}

const DateAndTimeSettingPanel = ( { attributes, setAttributes } ) =>
	( isEventPostType() && (
		<PluginDocumentSettingPanel
			name='datetime'
			title={ __( 'Date & Time', 'gatherpress' ) }
			initialOpen={ true }
			className="datetime"
		>
			<PanelRow>
				<span>
					{ __( 'Start', 'gatherpress' ) }
				</span>
				<Dropdown
					position="bottom left"
					contentClassName="edit-post-post-schedule__dialog"
					renderToggle={ ( { onToggle, isOpen } ) => (
						<>
							<Button
								className="edit-post-post-schedule__toggle"
								onClick={ onToggle }
								aria-expanded={ isOpen }
								isLink
							>
								<DateTimeStartLabel />
							</Button>
						</>
					) }
				renderContent={ () => <DateTimeStart /> }
				/>
			</PanelRow>
			<PanelRow>
				<span>
					{ __( 'End', 'gatherpress' ) }
				</span>
				<Dropdown
					position="bottom left"
					contentClassName="edit-post-post-schedule__dialog"
					renderToggle={ ( { onToggle, isOpen } ) => (
						<>
							<Button
								className="edit-post-post-schedule__toggle"
								onClick={ onToggle }
								aria-expanded={ isOpen }
								isLink
							>
								<DateTimeEndLabel />
							</Button>
						</>
					) }
					renderContent={ () => <DateTimeEnd /> }
				/>
			</PanelRow>
		</PluginDocumentSettingPanel>
	)
);

registerPlugin('date-and-time-setting-panel', {
	render: DateAndTimeSettingPanel,
	icon: ''
});

