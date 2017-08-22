const webpack = require('webpack');
const { resolve } = require('path');

module.exports = function() {
    return {
        context: resolve(__dirname, './../../src/userinterface/'), // The context is an absolute string to the directory that contains the entry files.
        entry: { // The entry object is where webpack looks to start building the bundle
            'mimoto.cms': ['babel-polyfill', './app/javascript/mimoto.cms.js'],
            'mimoto': './app/javascript/mimoto.js',
            'publisher': './publisher/base.js'
        },
        output: {
            path: resolve(__dirname, './../../web/static/js'),
            filename: '[name].min.js',
            publicPath: '/static/js/' // The bundled files will be available in the browser under this path
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
            new webpack.ProvidePlugin({
                $: "jquery",
                jQuery: "jquery",
                "window.jQuery": "jquery"
            })
        ]
    }
};