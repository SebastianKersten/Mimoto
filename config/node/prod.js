const webpack = require('webpack');
const webpackMerge = require('webpack-merge');
const baseConfig = require('./base');

module.exports = function(env) {
  return webpackMerge(baseConfig(), {
    devtool: 'cheap-source-map', // https://webpack.js.org/configuration/devtool/
    plugins: [
      new webpack.LoaderOptionsPlugin({
        minimize: true,
        debug: false
      }),
      new webpack.optimize.UglifyJsPlugin({
        beautify: false,
        mangle: {
          screw_ie8: true,
          keep_fnames: true
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
