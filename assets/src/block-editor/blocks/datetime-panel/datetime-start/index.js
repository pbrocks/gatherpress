import { DateTimePicker } from '@wordpress/components';
import { __experimentalGetSettings } from '@wordpress/date';

export function DateTimeStart( { date, updateDateTimeStart } ) {

	date = date ? date : GatherPress.event_datetime.datetime_start;

	const settings     = __experimentalGetSettings();
	const is12HourTime = /a(?!\\)/i.test(
		settings.formats.time
			.toLowerCase()
			.replace( /\\\\/g, '' )
			.split( '' ).reverse().join( '' )
	);

	return (
		<DateTimePicker
			currentDate = { date }
			onChange    = { ( date ) => updateDateTimeStart( date ) }
			is12Hour    = { is12HourTime }
		/>
	);
}

