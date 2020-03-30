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


registerBlockType( 'gatherpress/event-times', {
	title: __( 'Event Times', 'gatherpress' ),
	icon: {
		foreground: '#fff',
		background: '#23c3aa',
		src: 'clock',
	},
	category: 'gatherpress',
	keywords: [
		__( 'date', 'gatherpress'  ),
		__( 'event', 'gatherpress'  ),
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
			startDate: __( '31 July 2020 10:00 am', 'gatherpress' ),
			endDate: __( '31 July 2020 11:00 am', 'gatherpress' ),
		},
	},
	edit: function( { attributes, setAttributes, className } ) {

		const settings = __experimentalGetSettings();
		const is12HourTime = /a(?!\\)/i.test(
			settings.formats.time
			.toLowerCase()
			.replace( /\\\\/g, '' )
			.split( '' ).reverse().join( '' )
		);

		const {
			startDate,
			endDate
		} = attributes;

		const startMoment     = moment( startDate );
		let endMoment         = moment( endDate );
		endMoment             = moment( startDate ).add( 1, 'hour' );
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
			<div
				className={ className }
			>
				<div>
					<h3>{ eventDateTime }</h3>
				</div>
			</div>
		</Fragment>
		);
	},

	save: function( { attributes, className }) {
		const {
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

		return (
			<div
				className={ className }
			>
				<div>
					<h3>{ eventDateTime }</h3>
				</div>
			</div>
		);

	},

} );
