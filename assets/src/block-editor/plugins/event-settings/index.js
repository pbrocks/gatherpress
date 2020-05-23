import { isEventPostType } from '../helpers';
import { DateTimeStartSettingPanel } from './datetime-panel';
import { OptionsPanel} from './options-panel';

const { __ }                         = wp.i18n;
const { registerPlugin }             = wp.plugins;
const { PluginDocumentSettingPanel } = wp.editPost;

const EventSettings = () =>
	( isEventPostType() && (
		<PluginDocumentSettingPanel
			name        = 'gp-event-settings'
			title       = { __( 'Event settings', 'gatherpress' ) }
			initialOpen = { true }
			className   = 'gp-event-settings'
		>
			<DateTimeStartSettingPanel />
			<hr />
			<OptionsPanel />
		</PluginDocumentSettingPanel>
	)
);

registerPlugin( 'gp-event-settings', {
	render: EventSettings,
	icon: ''
} );
