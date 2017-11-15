const webpack = require('webpack');
const webpackMerge = require('webpack-merge');
const { resolve } = require('path');
const baseConfig = require('./base');

//const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const WriteFilePlugin = require('write-file-webpack-plugin');
const LatestBuildTimestampPlugin = require('latest-build-timestamp-webpack-plugin');

module.exports = function(env) {
    return webpackMerge(baseConfig(), {
        devtool: 'cheap-module-source-map', // https://webpack.js.org/configuration/devtool/
        //devServer: {
        //   contentBase: resolve(__dirname, './../../web'), // The folder from where the files get served
        //   compress: true, // Enable gzip compression for everything served
        //   port: 3100,
        //   hot: true,
        //   proxy: {
        //       '*': {
        //           target: 'http://mimoto.aimless',
        //           secure: false,
        //           changeOrigin: true
        //       }
        //   },
        //   historyApiFallback: true
        //},
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
                                    //includePaths: ['node_modules/foundation-sites/scss', 'node_modules/flatpickr/dist', 'node_modules/quill/dist']
                                    includePaths: ['node_modules/foundation-sites/scss', 'node_modules/flatpickr/dist']
                                }
                            }
                        ]
                    })
                }
            ]
        },
        plugins: [
            //new webpack.HotModuleReplacementPlugin(),
            //new webpack.NamedModulesPlugin(),
            new WriteFilePlugin({
                log: false,
                useHashIndex: true
            }),
            new LatestBuildTimestampPlugin(),
            // new BrowserSyncPlugin(
            //     // BrowserSync options
            //     {
            //         host: 'localhost',
            //         port: 3000,
            //         proxy: 'http://mimoto.aimless',
            //         open: true
            //     },
            //     // Plugin options
            //     {
            //         // Prevent BrowserSync from reloading the page and let Webpack Dev Server take care of this
            //         reload: true
            //     })
            //new BrowserSyncPlugin(
            //    // BrowserSync options
            //    {
            //        host: 'localhost',
            //        port: 3000,
            //        proxy: 'http://localhost:3100',
            //        open: true
            //    },
            //    // Plugin options
            //    {
            //        // Prevent BrowserSync from reloading the page and let Webpack Dev Server take care of this
            //        reload: false
            //    })
        ]
    });
};