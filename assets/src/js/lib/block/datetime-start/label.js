/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { dateI18n, __experimentalGetSettings } = wp.date;
const { withSelect } = wp.data;

export function DateTimeStartLabel( { date, isFloating } ) {
	const settings = __experimentalGetSettings();

	return date && ! isFloating
		? dateI18n(
				`${ settings.formats.date } ${ settings.formats.time }`,
				date
		  )
		: dateI18n(
				`${ settings.formats.date } ${ settings.formats.time }`,
				moment()
		  )
}

export default withSelect( ( select ) => {
	return {
		date: select( 'core/editor' ).getEditedPostAttribute( 'date' ),
		isFloating: select( 'core/editor' ).isEditedPostDateFloating(),
	};
} )( DateTimeStartLabel );
