const webpack = require('webpack');
const webpackMerge = require('webpack-merge');
const baseConfig = require('./base');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = function(env) {
  return webpackMerge(baseConfig(), {
    devtool: 'cheap-source-map', // https://webpack.js.org/configuration/devtool/
    module: {
      rules: [
        {
          test: /\.scss$/,
          use: ExtractTextPlugin.extract({
            fallback: 'style-loader',
            use: [
              {
                loader: 'css-loader',
                options: {
                  sourceMap: true,
                  importLoaders: 2
                }
              },
              {
                loader: 'postcss-loader',
                options: {
                  sourceMap: true,
                  plugins: () => {
                    return [
                      require('autoprefixer')({
                        browsers: 'last 10 versions'
                      })
                    ];
                  }
                }
              },
              {
                loader: 'sass-loader',
                options: {
                  sourceMap: true
                }
              }
            ]
          })
        }
      ]
    },
    plugins: [
      new ExtractTextPlugin('../css/[name].min.css'),
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
