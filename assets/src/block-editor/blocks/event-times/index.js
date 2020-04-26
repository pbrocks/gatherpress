import { __ }  from '@wordpress/i18n';

import {
	Fragment,
} from '@wordpress/element';

import { registerBlockType } from '@wordpress/blocks';

import {
	__experimentalGetSettings,
} from '@wordpress/date';

import {
	PanelBody,
	PanelRow,
	DateTimePicker,
} from '@wordpress/components';

import {
	InspectorControls,
} from '@wordpress/block-editor';

import apiFetch from '@wordpress/api-fetch';

registerBlockType( 'gatherpress/event-times', {
	title: __( 'Event Times', 'gatherpress' ),
	icon: {
		foreground: '#fff',
		background: '#23c3aa',
		src: 'clock',
	},
	category: 'gatherpress',
	keywords: [
		__( 'date', 'gatherpress' ),
		__( 'event', 'gatherpress' ),
	],
	attributes: {
		startDate: {
			type: 'string',
		},
		endDate: {
			type: 'string',
		},
	},
	example: {
		attributes: {

			startDate: '2020-04-16T09:20:17',
			endDate: '2020-04-16T11:20:17',
		},
	},
	edit: function( { attributes, setAttributes, className } ) {

window.FOOBAR = setAttributes;

		const settings     = __experimentalGetSettings();
		const is12HourTime = /a(?!\\)/i.test(
			settings.formats.time
				.toLowerCase() // Test only the lower case a
				.replace( /\\\\/g, '' ) // Replace "//" with empty strings
				.split( '' ).reverse().join( '' ) // Reverse the string and test for "a" not followed by a slash
		);

		let {
			startDate,
			endDate
		} = attributes;


		// Set default startDate and endDate in case user does not set onChange.
		if ( 'undefined' === typeof startDate ) {
			setAttributes( { startDate: moment().format( 'YYYY-MM-DTH:mm:ss' ) } );
		}

		if ( 'undefined' === typeof endDate ) {
			setAttributes( { endDate: moment().format( 'YYYY-MM-DTH:mm:ss' ) } );
		}

		const startMoment     = moment( startDate );
		const endMoment       = moment( endDate );
		const startDateFormat = startMoment.format( 'dddd, MMMM D, YYYY' );
		const endDateFormat   = endMoment.format( 'dddd, MMMM D, YYYY' );
		const startTimeFormat = startMoment.format( 'h:mm A' );
		const endTimeFormat   = endMoment.format( 'h:mm A' );

		let eventDateTime = startDateFormat + ' ' + startTimeFormat + ' to ' + endTimeFormat;

		if ( startDateFormat !== endDateFormat ) {
			eventDateTime = startDateFormat + ' ' + startTimeFormat + ' to ' + endDateFormat + ' ' + endTimeFormat;
		}

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody
						title={ __( 'Event Start', 'gatherpress' ) }
						initialOpen={ true }
					>
						<PanelRow>
							<DateTimePicker
								currentDate={ startDate }
								onChange={ ( date ) => {
									setAttributes( {
										startDate: date,
									} );
								} }
								locale={ settings.l10n.locale }
								is12Hour={ is12HourTime }
							/>
						</PanelRow>
					</PanelBody>

					<PanelBody
						title={ __( 'Event End', 'gatherpress' ) }
						initialOpen={ false }
					>
						<PanelRow>
							<DateTimePicker
								currentDate={ endDate }
								onChange={ ( date ) => {
									setAttributes( {
										endDate: date,
									} );
								} }
								locale={ settings.l10n.locale }
								is12Hour={ is12HourTime }
							/>
						</PanelRow>

					</PanelBody>

				</InspectorControls>
				<div className={ className }>
					<div>
						<h3>{ eventDateTime }</h3>
					</div>
				</div>
			</Fragment>
		);
	},

	save: function( { attributes, className }) {

		let {
			startDate,
			endDate
		} = attributes;

		const startMoment     = moment( startDate );
		const endMoment       = moment( endDate );
		const startDateFormat = startMoment.format( 'dddd, MMMM D, YYYY' );
		const endDateFormat   = endMoment.format( 'dddd, MMMM D, YYYY' );
		const startTimeFormat = startMoment.format( 'h:mm A' );
		const endTimeFormat   = endMoment.format( 'h:mm A' );

		let eventDateTime = '';

		if ( startDateFormat === endDateFormat ) {
			eventDateTime = startDateFormat + ' ' + startTimeFormat + ' to ' +endTimeFormat;
		} else {
			eventDateTime = startDateFormat + ' ' + startTimeFormat + ' to ' + endDateFormat + ' ' + endTimeFormat;
		}

		apiFetch(
			{
				path: '/gatherpress/v1/event/datetime/',
				method: 'POST',
				data: {
					post_id: GatherPress.post_id,
					datetime_start: startMoment.format( 'YYYY-MM-DD HH:mm:ss' ),
					datetime_end: endMoment.format( 'YYYY-MM-DD HH:mm:ss' ),
					_wpnonce: GatherPress.nonce,
				},
			}
		).then( ( res ) => {
			// Saved.
		} );

		return (
			<div className={ className }>
				<div>
					<h3>{ eventDateTime }</h3>
				</div>
			</div>
		);

	},

} );
