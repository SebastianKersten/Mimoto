var config       = require('../config/webpack')('production');
var gulp         = require('gulp');
var webpack      = require('webpack');


gulp.task('webpack:production', function (callback) {
  webpack(config, function() {
    callback();
  })
});
