const webpack = require('webpack');
const webpackMerge = require('webpack-merge');
const baseConfig = require('./base');

const WriteFilePlugin = require('write-file-webpack-plugin');

module.exports = function(env) {
    return webpackMerge(baseConfig(), {
        devtool: 'cheap-source-map', // https://webpack.js.org/configuration/devtool/
        plugins: [
            new WriteFilePlugin({
                log: false,
                useHashIndex: false
            }),
            new webpack.LoaderOptionsPlugin({
                minimize: true,
                debug: false
            }),
            new webpack.optimize.UglifyJsPlugin({
                beautify: false,
                mangle: {
                    screw_ie8: true,
                    keep_fnames: false
                },
                compress: {
                    screw_ie8: true
                },
                comments: false,
                sourceMap: true
            })
        ]
    });
};
