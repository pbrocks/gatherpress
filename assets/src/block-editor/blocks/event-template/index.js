import { __ }  from '@wordpress/i18n';

import { registerBlockType } from '@wordpress/blocks';

import {
	InnerBlocks,
} from '@wordpress/block-editor';


const GP_EVENT_TEMPLATE = [
	[ 'core/heading', { placeholder: 'Event Heading'} ],
	[ 'core/paragraph', { placeholder: 'Event Host' } ],
	[ 'core/image', {} ],
	[ 'core/paragraph', { placeholder: 'Image Details' } ],
	[ 'core/paragraph', { placeholder: 'Event Details' } ],
];

registerBlockType( 'gatherpress/event-template', {
	title: __( 'GatherPress Event Template', 'gatherpress' ),
	icon: {
		foreground: '#fff',
		background: '#23c3aa',
		src: 'carrot',
	},
	category: 'gatherpress',

	keywords: [
		__( 'container', 'block-starter' ),
		__( 'wrapper', 'block-starter' ),
		__( 'section', 'block-starter' ),
	],

	supports: {
		align: [ 'wide', 'full' ],
		anchor: true,
		html: false,
	},

	attributes: {
		content: {
			type: 'string',
		},
	},

	edit: ( props ) => {
		const { className } = props;

		return (
			<div className={ className }>
                <InnerBlocks
					template={GP_EVENT_TEMPLATE}
                    templateLock={true}
                    renderAppender={(
                        () => <InnerBlocks.ButtonBlockAppender/>
                    )}
                />
            </div>
		);
	},

	save: ( props ) => {
		const { className } = props;
		return (
			<div className={ className }>
				<InnerBlocks.Content />
			</div>
		);
	},
} );