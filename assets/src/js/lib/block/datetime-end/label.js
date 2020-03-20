/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { dateI18n, __experimentalGetSettings } = wp.date;
const { withSelect } = wp.data;

export function DateTimeEndLabel( { date, isFloating } ) {
	const settings = __experimentalGetSettings();

	return date && ! isFloating
		? dateI18n(
				`${ settings.formats.date } ${ settings.formats.time }`,
				date
		  )
		: dateI18n(
				`${ settings.formats.date } ${ settings.formats.time }`,
				moment().add( 2, 'hours' )
		  )
}

export default withSelect( ( select ) => {
	return {
		date: select( 'core/editor' ).getEditedPostAttribute( 'date' ),
		isFloating: select( 'core/editor' ).isEditedPostDateFloating(),
	};
} )( DateTimeEndLabel );
