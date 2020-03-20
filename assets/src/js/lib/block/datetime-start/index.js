import React from 'react';

const { __experimentalGetSettings } = wp.date;
const { withSelect, withDispatch } = wp.data;
const { compose } = wp.compose;
const { DateTimePicker } = wp.components;

export function DateTimeStart( { date, onUpdateDate } ) {
	const settings = __experimentalGetSettings();
	// To know if the current timezone is a 12 hour time with look for "a" in the time format
	// We also make sure this a is not escaped by a "/"
	const is12HourTime = /a(?!\\)/i.test(
		settings.formats.time
			.toLowerCase() // Test only the lower case a
			.replace( /\\\\/g, '' ) // Replace "//" with empty strings
			.split( '' )
			.reverse()
			.join( '' ) // Reverse the string and test for "a" not followed by a slash
	);

	return (
		<DateTimePicker
			key="date-time-picker"
			currentDate={ date }
			onChange={ onUpdateDate }
			is12Hour={ is12HourTime }
		/>
	);
}

export default compose( [
	withSelect( ( select ) => {
		return {
			date: select( 'core/editor' ).getEditedPostAttribute( 'date' ),
		};
	} ),
	withDispatch( ( dispatch ) => {
		return {
			onUpdateDate( date ) {
				dispatch( 'core/editor' ).editPost( { date } );
			},
		};
	} ),
] )( DateTimeStart );
