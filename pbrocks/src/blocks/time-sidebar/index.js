
import { __ } from '@wordpress/i18n';

import { registerBlockType } from '@wordpress/blocks';

import {
    PanelBody,
    PanelRow,
} from '@wordpress/components';

import {
	InspectorControls,
	RichText,
	TextControl,
} from '@wordpress/block-editor';

import StartTime from './date-time-start';

// import { withState } from '@wordpress/compose';
 

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
        const { attributes: { content }, setAttributes, className } = props;
        const onChangeContent = ( newContent ) => {
            setAttributes( { content: newContent } );
        };

        return (
			<>
			<InspectorControls>
			<PanelBody
				title='Time Input Sidebar'
				icon='welcome-widgets-menus'
				initialOpen={ true }
			>
            <PanelRow>
                <h3>Time Inputs Panel and Labels</h3>
            </PanelRow>
				<PanelRow>
                    <StartTime />
				</PanelRow>
				</PanelBody>
            </InspectorControls>
            <RichText
                placeholder="Datetime"
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