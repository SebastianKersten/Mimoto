const webpack = require('webpack');
const webpackMerge = require('webpack-merge');
const { resolve } = require('path');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const baseConfig = require('./base');

module.exports = function(env) {
    return webpackMerge(baseConfig(), {
        devtool: 'cheap-module-source-map', // https://webpack.js.org/configuration/devtool/
        devServer: {
            contentBase: resolve(__dirname, './../../web'), // The folder from where the files get served
            compress: true, // Enable gzip compression for everything served
            port: 3100,
            hot: true
        },
        module: {
            rules: [
                {
                    test: /\.scss$/,
                    use: [
                        {
                            loader: 'style-loader',
                            options: {
                                sourceMap: true
                            }
                        },
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
                                sourceMap: true
                            }
                        }
                    ]
                }
            ]
        },
        plugins: [
            new webpack.HotModuleReplacementPlugin(),
            new webpack.NamedModulesPlugin(),
            new BrowserSyncPlugin(
                // BrowserSync options
                {
                    // Browse to http://localhost:3000/ during development
                    host: 'localhost',
                    port: 3000,
                    // Proxy the Webpack Dev Server endpoint through BrowserSync
                    proxy: 'http://mimoto.aimless',
                    open: true
                },
                // Plugin options
                {
                    // Prevent BrowserSync from reloading the page and let Webpack Dev Server take care of this
                    reload: false
                })
        ]
    });
};