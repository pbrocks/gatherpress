import { dateI18n, __experimentalGetSettings } from '@wordpress/date';

export function DateTimeEndLabel( { date, isOpen } ) {
	const settings = __experimentalGetSettings();

	return dateI18n(
		`${ settings.formats.date } ${ settings.formats.time }`,
		date
	);
}
