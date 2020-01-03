module.exports = {
	syntax: 'postcss-scss',
	plugins: {
		'postcss-import': {},
		'postcss-cssnext': {
			warnForDuplicates: false
		},
		'postcss-pxtorem': {
			rootValue: 16,
			unitPrecision: 5,
			propList: ['*'],
			selectorBlackList: [],
			replace: true,
			mediaQuery: true,
			minPixelValue: 2
		},
		'lost': {}
	}
}