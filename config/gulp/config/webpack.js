var path = require('path'); // https://nodejs.org/docs/latest/api/path.html
var paths = require('./'); // Requires index.js
var webpack = require('webpack');

module.exports = function (env) {

  var jsSrc = path.resolve(paths.src + '/src/userinterface');
  var jsDest = paths.dest + '/js/';
  var publicPath = paths.dest + '/js/';

  var webpackConfig = {

    context: jsSrc,
    plugins: [
      new webpack.ProvidePlugin({
        EH: 'ErrorHandling',
        FV: 'FormValidation',
        $: "jquery",
        jQuery: "jquery",
        "window.jQuery": "jquery"
      })
    ],
    resolve: {
      modulesDirectories: ['node_modules', 'src/userinterface/MimotoCMS/components/', 'src/userinterface/app/javascript/utils'],
      extensions: ['', '.js'],
      alias: {
        'jquery-ui': 'jquery-ui-dist/jquery-ui.js'
      }
    },
    entry: {
      'mimoto.cms': [jsSrc + '/app/javascript/mimoto.cms.js'],
      'mimoto.aimless': [jsSrc + '/app/javascript/mimoto.aimless.js']
    },
    output: {
      path: jsDest,
      filename: '[name].js',
      publicPath: publicPath
    }

  };

  if (env === 'development') {

    webpackConfig.devtool = 'source-map';
    webpack.debug = true

  }

  if (env === 'production') {

    webpackConfig.plugins.push(
      new webpack.optimize.DedupePlugin(),
      new webpack.optimize.UglifyJsPlugin({
        output: {comments: false},
        minimize: true,
        comments: false,
        sourceMap: false,
        compress:{
          loops: true,
          booleans: true,
          dead_code: true,
          conditionals: true,
          screw_ie8: true,
          comparisons: true,
          warnings: true,
          drop_console: true,
          global_defs: { DEBUG: false }
        }
      })
    );

  }

  return webpackConfig;

};
