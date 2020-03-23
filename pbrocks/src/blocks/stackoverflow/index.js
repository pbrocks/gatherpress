import classnames from 'classnames'
import ResizableBox from 're-resizable'

const { isFinite, find, omit } = window.lodash;
const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { 
    PanelBody, 
    DateTimePicker,
} = wp.components;
const { __experimentalGetSettings  } = wp.date;
const { Fragment } = wp.element;
const { compose,withState } = wp.compose;
const {
    InspectorControls,
    InnerBlocks,
} = wp.editor;

registerBlockType( 'block/timed-block', {
    title: __( 'Timed block' ), // Block title.
    icon: 'align-center', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
    category: 'layout', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
    keywords: [
        __( 'section' ),
        __( 'container' ),
    ],
    attributes: {
        dateFrom: {
            type: 'strings',
        },
        dateTo: {
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
            dateFrom,
            dateTo
        } = attributes;

        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody
                        title={ __( 'Date from' ) }
                        initialOpen={ false }
                    >
                     <DateTimePicker
                            currentDate={ dateFrom }
                            onChange={ ( date ) => {
                                setAttributes( {
                                    dateFrom: date,
                                } );
                            } }
                            locale={ settings.l10n.locale }
                            is12Hour={ is12HourTime }
                        />
                    </PanelBody>
                    <PanelBody
                        title={ __( 'Date to' ) }
                        initialOpen={ false }
                    >
                    <DateTimePicker
                            currentDate={ dateTo }
                            onChange={ ( date ) => {
                                setAttributes( {
                                    dateTo: date,
                                } );
                            } }
                            locale={ settings.l10n.locale }
                            is12Hour={ is12HourTime }
                        />

                    </PanelBody>

                </InspectorControls>
                <section
                className={ className }
                >   
                    <InnerBlocks />
                </section>
            </Fragment>
        );
    },

    save: function( { attributes, className }) {
        const { 
            dateFrom,
            dateTo
        } = attributes;

            return (
                <section className={className}>
                <InnerBlocks.Content />
                </section>
            );


    },

    /**
     * wrapper props
     * @param {*} attributes 
     */
    getEditWrapperProps( attributes ) {
        return { 'data-align': 'wide' };
    },
} );