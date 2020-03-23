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
        __( 'section', 'gatherpress'  ),
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
    edit: function( {  attributes, setAttributes,className }) {

        const settings = __experimentalGetSettings();
        const is12HourTime = /a(?!\\)/i.test(
            settings.formats.time
                .toLowerCase() // Test only the lower case a
                .replace( /\\\\/g, '' ) // Replace "//" with empty strings
                .split( '' ).reverse().join( '' ) // Reverse the string and test for "a" not followed by a slash
        );

        const { 
            startDate,
            endDate
        } = attributes;

        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody
                        title={ __( 'Event Start Time', 'gatherpress' ) }
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
                        title={ __( 'Event End Time', 'gatherpress' ) }
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
                <section
                    className={ className }
                    style={{border:"1px solid"}}
                >   
                    <div>
                    <h3>Start Time =  { startDate }</h3>
                    </div>
                    <div>
                    <h3>End Time = { endDate }</h3>
                    </div>
                </section>
            </Fragment>
        );
    },

    save: function( { attributes, className }) {
        const { 
            startDate,
            endDate
        } = attributes;

            return (
                <section
                    className={ className }
                    style={{border:"1px solid"}}
                >   
                <div>
                <h3>Start Time =  { startDate }</h3>
                </div>
                <div>
                <h3>End Time = { endDate }</h3>
                </div>
                </section>
            );


    },

} );