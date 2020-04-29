import { DateTimePicker } from '@wordpress/components';
import { __experimentalGetSettings } from '@wordpress/date';
import { withState } from '@wordpress/compose';

export const DateTimeEnd = withState( {
	date: GatherPress.event_datetime.datetime_end,
} )( ( { updateDateTimeEnd, getDateTimeEnd, setState } ) => {

	const settings     = __experimentalGetSettings();
	const is12HourTime = /a(?!\\)/i.test(
		settings.formats.time
			.toLowerCase()
			.replace( /\\\\/g, '' )
			.split( '' ).reverse().join( '' )
	);

	return (
		<DateTimePicker
			currentDate = { getDateTimeEnd() }
			onChange    = { ( date ) => updateDateTimeEnd( date, setState ) }
			is12Hour    = { is12HourTime }
		/>
	);
} );
