const webpack = require('webpack');
const { resolve } = require('path');

const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = function() {
    return {
        context: resolve(__dirname, './../../src/userinterface/'), // The context is an absolute string to the directory that contains the entry files.
        entry: { // The entry object is where webpack looks to start building the bundle
            'js/mimoto.cms.js': ['babel-polyfill', './MimotoCMS/mimoto.cms.js'],
            'js/mimoto.js': './Mimoto/mimoto.js',
            'js/publisher.js': './publisher/publisher.js',
            'css/mimoto.cms.css': './MimotoCMS/mimoto.cms.scss',
            'css/publisher.css': './publisher/publisher.scss',
            'css/thetimeline.css': './thetimeline/thetimeline.scss'
        },
        output: {
            path: resolve(__dirname, './../../web/static'),
            filename: '[name]'
            //publicPath: '/static/'
        },
        resolve: {
            modules: ['node_modules', 'src/userinterface/MimotoCMS/components', 'src/userinterface/MimotoCMS/modules'],
            // alias: {
            //     'jquery-ui': resolve('node_modules', 'jquery-ui-dist/jquery-ui.js')
            // }
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
            new webpack.ExtendedAPIPlugin(),
            new ExtractTextPlugin('[name]')
            // new webpack.ProvidePlugin({
            //     $: "jquery",
            //     jQuery: "jquery",
            //     "window.jQuery": "jquery"
            // })
        ]
    };
};