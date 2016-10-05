var config       = require('../config/webpack')('development');
var gulp         = require('gulp');
var webpack      = require('webpack');
var browserSync  = require('browser-sync');

gulp.task('webpack:development', function () {
  webpack(config).watch(200, function () {
    browserSync.reload();
  })
});
