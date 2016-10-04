var path = require('path'); // https://nodejs.org/docs/latest/api/path.html
var paths = require('./'); // Requires index.js
var webpack = require('webpack');

module.exports = function (env) {

  var jsSrc = path.resolve(paths.src + '/src/userinterface');
  var jsDest = paths.dest + '/js/';
  var publicPath = paths.dest + '/js/';

  var webpackConfig = {

    context: jsSrc,
    resolve: {
      modulesDirectories: ['node_modules', 'src/userinterface/MimotoCMS/components/'],
      extensions: ['', '.js']
    },
    entry: {
      app: [jsSrc + '/app/javascript/app.js']
    },
    output: {
      path: jsDest,
      filename: '[name].min.js',
      publicPath: publicPath
    }

  };

  if (env === 'development') {

    webpackConfig.devtool = 'source-map';
    webpack.debug = true

  }

  return webpackConfig;

};
