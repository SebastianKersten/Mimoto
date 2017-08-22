const webpack = require('webpack');
const webpackMerge = require('webpack-merge');
const { resolve } = require('path');
const baseConfig = require('./base');

const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const WriteFilePlugin = require('write-file-webpack-plugin');

module.exports = function(env) {
    return webpackMerge(baseConfig(), {
        devtool: 'cheap-module-source-map', // https://webpack.js.org/configuration/devtool/
        module: {
            rules: [
                {
                    test: /\.scss$/,
                    use: ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: [
                            {
                                loader: 'css-loader',
                                options: {
                                    sourceMap: true,
                                    importLoaders: 2
                                }
                            },
                            {
                                loader: 'postcss-loader',
                                options: {
                                    sourceMap: true,
                                    plugins: () => {
                                        return [
                                            require('autoprefixer')({
                                                browsers: 'last 10 versions'
                                            })
                                        ];
                                    }
                                }
                            },
                            {
                                loader: 'sass-loader',
                                options: {
                                    sourceMap: true,
                                    includePaths: ['node_modules/foundation-sites/scss', 'node_modules/flatpickr/dist']
                                }
                            }
                        ]
                    })
                }
            ]
        },
        plugins: [
            new WriteFilePlugin({
                log: false,
                useHashIndex: true
            }),
            new BrowserSyncPlugin(
                // BrowserSync options
                {
                    port: 3000,
                    proxy: 'http://mimoto.aimless'
                },
                // Plugin options
                {
                    // Prevent BrowserSync from reloading the page and let Webpack Dev Server take care of this
                    reload: false
                })
        ]
    });
};