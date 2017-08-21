const webpack = require('webpack');
const webpackMerge = require('webpack-merge');
const baseConfig = require('./base');

module.exports = function(env) {
  return webpackMerge(baseConfig(), {
    devtool: 'cheap-module-source-map' // https://webpack.js.org/configuration/devtool/
  });
};
