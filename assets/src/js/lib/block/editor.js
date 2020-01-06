/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */

wp.blocks.registerBlockType( 'gatherpress/duration', {
	title: 'Duration',
	icon: 'clock',
	category: 'common',
	attributes: {
		content: {type: 'string'},
		color: {type: 'string'}
	},

	/* This configures how the content and color fields will work, and sets up the necessary elements */

	edit: function(props) {
		function updateContent(event) {
			props.setAttributes({content: event.target.value})
		}
		return React.createElement(
			'div',
			null,
			React.createElement(
				'h3',
				null,
				'Date & Time'
			),
			React.createElement(
				'label',
				null,
				'Start',
				React.createElement(
					'input',
					{
						type: 'date',
						value: props.attributes.content,
						onChange: updateContent
					}
				),
				React.createElement(
					'input',
					{
						type: 'time',
						value: props.attributes.content,
						onChange: updateContent
					}
				),
			),
			React.createElement(
				'br',
				null,
			),
			React.createElement(
				'label',
				null,
				'End',
				React.createElement(
					'input',
					{
						type: 'date',
						value: props.attributes.content,
						onChange: updateContent
					}
				),
				React.createElement(
					'input',
					{
						type: 'time',
						value: props.attributes.content,
						onChange: updateContent
					}
				),
			),
		);
	},
	save: function(props) {
		return wp.element.createElement(
		"h3",
		{ style: { border: "3px solid " + props.attributes.color } },
		props.attributes.content
		);
	}
})