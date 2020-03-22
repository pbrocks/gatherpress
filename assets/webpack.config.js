const defaultConfig = require( './node_modules/@wordpress/scripts/config/webpack.config.js' );
const path = require( 'path' );
const postcssPresetEnv = require( 'postcss-preset-env' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const IgnoreEmitPlugin = require( 'ignore-emit-webpack-plugin' );
const copyWebpackPlugin = require( 'copy-webpack-plugin' );
const production = process.env.NODE_ENV === '';
const buildDir = path.resolve( __dirname, 'build' );
const srcDir = path.resolve( __dirname, 'build' );
const assets = {
	js: [
		'index',
		'blocks',
	],
	scss: [
		'style',
		'editor',
		'admin',
	],
};
const copyWebpackConfig = [
	{
		context: 'src/fonts/',
		from: '**/*',
		to: buildDir + '/fonts/'
	},
	{
		context: 'src/images/',
		from: '**/*',
		to: buildDir + '/images/'
	}
];

let entries      = {};
let omitFiles = [];

for ( let type in assets ) {
	for ( let j = 0; j < assets[ type ].length; j++ ) {
		let asset = assets[ type ][ j ];

		entries[ asset ] = path.resolve( process.cwd(), 'src/' + type, asset + '.' + type );
		omitFiles.push( asset + '.asset.php' );

		if ( 'js' !== type ) {
			omitFiles.push( asset + '.js' );
		}
	}
}
module.exports = {
	...defaultConfig,
	entry: entries,
	externals: {
		jquery: 'jQuery'
	},
	output: {
		path: buildDir + '/',
		filename: 'js/[name].js'
	},
	optimization: {
		...defaultConfig.optimization,
		splitChunks: {
			cacheGroups: {
				editor: {
					name: 'editor',
					test: /editor\.(sc|sa|c)ss$/,
					chunks: 'all',
					enforce: true,
				},
				style: {
					name: 'style',
					test: /style\.(sc|sa|c)ss$/,
					chunks: 'all',
					enforce: true,
				},
				default: false,
			},
		},
	},
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.(sc|sa|c)ss$/,
				exclude: /(node_modules|nobundle|vendor)/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
					},
					{
						loader: 'css-loader',
						options: {
							sourceMap: ! production,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							ident: 'postcss',
							plugins: () => [
								postcssPresetEnv( {
									stage: 3,
									features: {
										'custom-media-queries': {
											preserve: false,
										},
										'custom-properties': {
											preserve: true,
										},
										'nesting-rules': true,
									},
								} ),
							],
						},
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: ! production,
						},
					},
				],
			},
		],
	},
	plugins: [
		...defaultConfig.plugins,
		new MiniCssExtractPlugin( {
			filename: 'css/[name].css',
		} ),
		new IgnoreEmitPlugin( omitFiles ),
		new copyWebpackPlugin( copyWebpackConfig ),
	],
};
