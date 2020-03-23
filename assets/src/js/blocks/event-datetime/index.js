/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */
const {
	TextControl,
	CheckboxControl,
	RadioControl,
	SelectControl,
	TextareaControl,
	ToggleControl,
	RangeControl,
	DateTimePicker,
	Panel,
	PanelBody,
	PanelRow
} = wp.components;
const el = wp.element.createElement;
	const { RichText, InspectorControls } = wp.blockEditor;
	const { Fragment } = wp.element;
	const { registerBlockType } = wp.blocks;

registerBlockType( 'gatherpress/duration', {
	title: 'Duration',
	icon: 'clock',
	category: 'common',
	attributes: {
		content: {type: 'string'},
		color: {type: 'string'}
	},

	/* This configures how the content and color fields will work, and sets up the necessary elements */

	edit: function(props) {
		return (
			el( Fragment, {},
				el( InspectorControls, {},
					el( PanelBody, { title: 'Form Settings', initialOpen: true },

						/* Text Field */
						el( PanelRow, {},
							el( TextControl,
								{
									label: 'List ID',
									onChange: ( value ) => {
										props.setAttributes( { list_id: value } );
									},
									value: props.attributes.list_id
								}
							)
						),

					/* Text Field */
					el( PanelRow, {},
						el( DateTimePicker,
							{
								label: 'Start',
								onChange: ( value ) => {
									props.setAttributes( { datetimestart: value } );
								},
								value: props.attributes.datetimestart
							}
						)
					),

						/* Toggle Field */
						el( PanelRow, {},
							el( ToggleControl,
								{
									label: 'Double Opt In',
									onChange: ( value ) => {
										props.setAttributes( { doubleoptin: value } );
									},
									checked: props.attributes.doubleoptin,
								}
							)
						)

					),

				),

				/*
				 * Here will be your block markup
				 */
				<h5>Monday, April 13, 2020</h5>
			)
		)











		// function updateContent(event) {
		// 	props.setAttributes({content: event.target.value})
		// }
		// return React.createElement(
		// 	'div',
		// 	null,
		// 	React.createElement(
		// 		'h3',
		// 		null,
		// 		'Date & Time'
		// 	),
		// 	React.createElement(
		// 		'label',
		// 		null,
		// 		'Start',
		// 		React.createElement(
		// 			'input',
		// 			{
		// 				type: 'date',
		// 				value: props.attributes.content,
		// 				onChange: updateContent
		// 			}
		// 		),
		// 		React.createElement(
		// 			'input',
		// 			{
		// 				type: 'time',
		// 				value: props.attributes.content,
		// 				onChange: updateContent
		// 			}
		// 		),
		// 	),
		// 	React.createElement(
		// 		'br',
		// 		null,
		// 	),
		// 	React.createElement(
		// 		'label',
		// 		null,
		// 		'End',
		// 		React.createElement(
		// 			'input',
		// 			{
		// 				type: 'date',
		// 				value: props.attributes.content,
		// 				onChange: updateContent
		// 			}
		// 		),
		// 		React.createElement(
		// 			'input',
		// 			{
		// 				type: 'time',
		// 				value: props.attributes.content,
		// 				onChange: updateContent
		// 			}
		// 		),
		// 	),
		// );
	},
	save: function(props) {
		return wp.element.createElement(
		"h3",
		{ style: { border: "3px solid " + props.attributes.color } },
		props.attributes.content
		);
	}
})
