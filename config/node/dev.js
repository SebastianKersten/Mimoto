const webpack = require('webpack');
const webpackMerge = require('webpack-merge');
const baseConfig = require('./base');

const WriteFilePlugin = require('write-file-webpack-plugin');

module.exports = function(env) {
    return webpackMerge(baseConfig(), {
        devtool: 'cheap-module-source-map', // https://webpack.js.org/configuration/devtool/
        plugins: [
            new WriteFilePlugin({
                log: false,
                useHashIndex: true
            })
        ]
    });
};
