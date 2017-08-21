const webpack = require('webpack');
const { resolve } = require('path');

module.exports = function() {
  return {
    context: resolve(__dirname, './../../src/userinterface/'), // The context is an absolute string to the directory that contains the entry files.
    entry: { // The entry object is where webpack looks to start building the bundle
      'realtime' : './app/javascript/realtime.js'
    },
    target: 'node',
    output: {
      path: resolve(__dirname, './../../web/static/js'),
      filename: '[name].min.js',
      publicPath: '/static/js/' // The bundled files will be available in the browser under this path
    },
    resolve: {
      modules: ['node_modules', 'src/userinterface/MimotoCMS/components', 'src/userinterface/MimotoCMS/modules']
    },
    module: {
      rules: [
        {
          test: /\.js$/, // Check for all js files
          exclude: /node_modules/,
          loader: 'babel-loader'
        }
      ]
    }
  }
};
