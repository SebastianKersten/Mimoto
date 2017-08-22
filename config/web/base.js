const webpack = require('webpack');
const { resolve } = require('path');

const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = function() {
    return {
        context: resolve(__dirname, './../../src/userinterface/'), // The context is an absolute string to the directory that contains the entry files.
        entry: { // The entry object is where webpack looks to start building the bundle
            'js/mimoto.cms.js': ['babel-polyfill', './app/javascript/mimoto.cms.js'],
            'js/mimoto.js': './app/javascript/mimoto.js',
            'js/publisher.js': './publisher/base.js',
            'css/mimoto.cms.css': './app/scss/mimoto.cms.scss',
            'css/publisher.css': './app/scss/publisher.scss',
            'css/thetimeline.css': './app/scss/thetimeline.scss'
        },
        output: {
            path: resolve(__dirname, './../../web/static'),
            filename: '[name]'
            //publicPath: '/static/'
        },
        resolve: {
            modules: ['node_modules', 'src/userinterface/MimotoCMS/components', 'src/userinterface/MimotoCMS/modules'],
            alias: {
                'jquery-ui': resolve('node_modules', 'jquery-ui-dist/jquery-ui.js')
            }
        },
        module: {
            rules: [
                {
                    test: /\.js$/, // Check for all js files
                    exclude: /node_modules/,
                    loader: 'babel-loader'
                }
            ]
        },
        plugins: [
            new ExtractTextPlugin('[name]'),
            new webpack.ProvidePlugin({
                $: "jquery",
                jQuery: "jquery",
                "window.jQuery": "jquery"
            })
        ]
    };
};