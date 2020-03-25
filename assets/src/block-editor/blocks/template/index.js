const el = wp.element.createElement;
const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.blockEditor;

const GP_EVENT_TEMPLATE = [
	[ 'core/heading', { placeholder: 'Event Heading'} ],
	[ 'core/paragraph', { placeholder: 'Event Host' } ],
	[ 'core/image', {} ],
	[ 'core/paragraph', { placeholder: 'Image Details' } ],
	[ 'core/paragraph', { placeholder: 'Event Details' } ],
];

registerBlockType( 'gatherpress/event-template', {
	title: 'GatherPress Event Template',
	category: 'gatherpress',
	edit: ( props ) => {
		return el( InnerBlocks, {
			template: GP_EVENT_TEMPLATE,
			templateLock: true
		});
	},
	save: ( props ) => {
		return el( InnerBlocks.Content, {} );
	},
});