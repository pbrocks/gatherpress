'use strict';

// Webpack dependencies
var path = require('path');
var webpack = require('webpack');

// Variables
const ROOT_DIR      = path.resolve(__dirname);
const CONFIG_DIR    = path.resolve(__dirname, 'config');
const SRC_DIR       = path.resolve(__dirname, 'src');
const BUILD_DIR     = path.resolve(__dirname, 'build');

const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const devMode = process.argv.indexOf('production') === -1;

//=========================================================
//  Entry
//---------------------------------------------------------
const entry = {
	main: CONFIG_DIR + '/main.js',
	block_style: CONFIG_DIR + '/block/style.js',
	block_editor: CONFIG_DIR + '/block/editor.js',
	admin: CONFIG_DIR + '/admin.js',
};

/**
 * Clean webpack plugin, To cleanup directory.
 * i.g. build/
 *
 * Reference : https://github.com/johnagan/clean-webpack-plugin
 *
 * @type Module clean-webpack-plugin|Module clean-webpack-plugin
 */
const cleanWebpackPlugin = require('clean-webpack-plugin');

/**
 * Clone plugin.
 *
 * @type Module copy-webpack-plugin|Module copy-webpack-plugin
 */
const copyWebpackPlugin = require('copy-webpack-plugin');
const copyWebpackConfig = [
	{
		context: 'src/fonts/',
		from: '**/*',
		to: BUILD_DIR + '/fonts'
	},
	{
		context: 'src/images/',
		from: '**/*',
		to: BUILD_DIR + '/images'
	}
];

module.exports = {
	mode: 'production',
	entry: entry,
	output: {
		path: BUILD_DIR + '/',
		filename: 'js/[name].js'
	},
	externals: {
		jquery: 'jQuery'
	},
	optimization: {
		minimizer: [
			new UglifyJsPlugin({
				cache: true,
				extractComments: true,
				parallel: true,
				sourceMap: true, // set to true if you want JS source maps
				test: /\.js(\?.*)?$/i
			}),
			new OptimizeCSSAssetsPlugin({})
		]
	},
	plugins: [
		new MiniCssExtractPlugin({
			// Options similar to the same options in webpackOptions.output
			// both options are optional
			filename: 'css/[name].css',
			chunkFilename: 'css/[id].css'
		}),
		new copyWebpackPlugin(copyWebpackConfig)
	],
	watch: devMode,
	watchOptions: {
		ignored: /node_modules/
	},
	devtool: 'source-map',
	module: {
		rules: [{
			test: /\.jsx?$/,
			include: SRC_DIR,
			exclude: /node_modules/,
			use: [{
				loader: 'babel-loader',
				options: {
					presets: ['@babel/preset-env', '@babel/preset-react' ]
				}
			}]
		}, {
			test: /\.(sa|sc|c)ss$/,
			include: SRC_DIR,
			exclude: /node_modules/,
			use: [{
				loader: MiniCssExtractPlugin.loader
			}, {
				loader: "css-loader", options: {
					url: false,
					importLoaders: 1,
					sourceMap: true
				}
			}, {
				loader: 'postcss-loader', options: {
					sourceMap: true
				}
			}, {
				loader: "sass-loader", options: {
					sourceMap: true
				}
			}]
		}, {
			test: /\.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
			use: [{
				loader: "file-loader", options: {
					name: function (path) {
						return path.replace(SRC_DIR + '/', '');
					}
				}
			}]
		}, {
			test: /\.(gif|jpe?g|png)$/,
			use: [{
				loader: "file-loader", options: {
					name: function (path) {
						return path.replace(SRC_DIR + '/', '');
					}
				}
			}]
		}]
	}
};
