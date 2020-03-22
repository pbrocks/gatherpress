import { __ } from '@wordpress/i18n';

import { registerBlockType } from '@wordpress/blocks';
 
import {
    RichText,
    InspectorControls,
    AlignmentToolbar,
    BlockControls,
} from '@wordpress/block-editor';

import {
	Button,
	Dashicon,
	PanelColorSettings,
	PanelBody,
	PanelRow,
	TextControl,
	TextareaControl,
} from '@wordpress/components';

registerBlockType( 'gather-blocks/time-sidebar', {
    title: 'Time: Controls',
    icon: 'universal-access-alt',
    category: 'gather-blocks',
    attributes: {
        title: {
            type: 'array',
            selector: 'h2',
        },
        content: {
            type: 'array',
            source: 'children',
            selector: 'p',
        },
        alignment: {
            type: 'string',
            default: 'none',
        },
		paragraphBG: {
			type: 'string',
			default: '#a04',
		},
    },
    example: {
        attributes: {
            content: 'Hello World',
            alignment: 'right',
        },
    },
    edit: ( props ) => {
        const {
            attributes: {
                content,
                title,
                alignment,
                paragraphBG,
            },
            className,
        } = props;
 
        const onChangeTitle = ( newTitle ) => {
            props.setAttributes( { title: newTitle } );
        };
 
        const onChangeContent = ( newContent ) => {
            props.setAttributes( { content: newContent } );
        };
 
        const onChangeAlignment = ( newAlignment ) => {
            props.setAttributes( { alignment: newAlignment === undefined ? 'none' : newAlignment } );
        };
 
        return (
			<>
			<InspectorControls>
			<PanelBody
			    title="Audio Player Text"
			    icon="welcome-widgets-menus"
			    initialOpen={ true }
			>
            <PanelRow>
                <h3>Change your color here</h3>
            </PanelRow>
				<PanelRow>
					<TextControl
						tagName="h2"
						placeholder={ __( 'Gathering Title', 'gatherpress' ) }
						className={ 'gathering-title' }
						onChange={ onChangeTitle }
						value={ title }
					/>
				</PanelRow>
				<PanelRow>
					<TextareaControl
						tagName="p"
						placeholder={ __( 'Gathering Description', 'gatherpress' ) }
						className={ 'gathering-description' }
						onChange={ onChangeContent }
						value={ content }
					/>
				</PanelRow>
			</PanelBody>
			</InspectorControls>
            <div>
                {
                    <BlockControls>
                        <AlignmentToolbar
                            value={ alignment }
                            onChange={ onChangeAlignment }
                        />
                    </BlockControls>
                }
                <RichText
                    className={ className }
                    style={ { textAlign: alignment } }
                    tagName="h2"
                    onChange={ onChangeTitle }
                    label="{ title }"
                    value={ title }
                />
                <RichText
                    className={ className }
                    style={ { textAlign: alignment } }
                    tagName="p"
                    onChange={ onChangeContent }
                    value={ content }
                />
            </div>
            </>
        );
    },
    save: ( props ) => {
        return (
            <RichText.Content
                className={ `gather-blocks-align-${ props.attributes.alignment }` }
                tagName="p"
                value={ props.attributes.content }
            />
        );
    },
} );
