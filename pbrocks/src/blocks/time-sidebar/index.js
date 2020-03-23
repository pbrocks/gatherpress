
import { __ } from '@wordpress/i18n';

import { registerBlockType } from '@wordpress/blocks';

import {
    withState,
    setState,
} from '@wordpress/data';

import {
    PanelBody,
    PanelRow,
} from '@wordpress/components';

import {
	InspectorControls,
	RichText,
} from '@wordpress/block-editor';

registerBlockType( 'gatherpress/time-sidebar', {
    title: 'Gather: Times',
    icon: { 
        background: '#23c3aa',
        foreground: '#fff',
        src: 'clock',
    },
    category: 'gatherpress',
    attributes: {
        content: {
            type: 'array',
            source: 'children',
            selector: 'p',
        },
        date: {
            type: 'string',
        }
    },
    example: {
        attributes: {
            content: 'Hello World',
            date: '31 July 2001',
        },
    },
    edit: ( props ) => {
        const { attributes: { content, date }, setAttributes, className } = props;
        const onChangeContent = ( newContent ) => {
            setAttributes( { content: newContent } );
        };
 
		const StartDateTimePicker = withState( {
		    date: new Date(),
		} )( ( { date, setState } ) => {
		    const settings = __experimentalGetSettings();
		 
		    // To know if the current timezone is a 12 hour time with look for an "a" in the time format.
		    // We also make sure this a is not escaped by a "/".
		    const is12HourTime = /a(?!\\)/i.test(
		        settings.formats.time
		            .toLowerCase() // Test only the lower case a
		            .replace( /\\\\/g, '' ) // Replace "//" with empty strings
		            .split( '' ).reverse().join( '' ) // Reverse the string and test for "a" not followed by a slash
		    );
		 
		    return (
		        <DateTimePicker
		            currentDate={ date }
		            onChange={ ( date ) => setState( { date } ) }
		            is12Hour={ is12HourTime }
		        />
		    );
		} );

        return (
            <>
            <InspectorControls>
            <PanelBody
                title="Time Input Sidebar"
                icon="welcome-widgets-menus"
                initialOpen={ true }
            >
            <PanelRow>
                <h3>Time Inputs Panel and Labels</h3>
            </PanelRow>
                <PanelRow>
                    <div className={className} >
                        <StartDateTimePicker />
                    </div>
                </PanelRow>
                </PanelBody>
            </InspectorControls>
            <RichText
                tagName="p"
                className={ className }
                onChange={ onChangeContent }
                value={ content }
            />
            
            </>
        );
    },
    save: ( props ) => {
        return <RichText.Content tagName="p" value={ props.attributes.content } />;
    },
} );