var config = require('../config');
var sassConfig = require('../config/sass');

var gulp = require('gulp');
var watch = require('gulp-watch');
var browserSync = require('browser-sync');

gulp.task('watch', function () {

  watch(sassConfig.src, function () {
    gulp.start('sass:development');
  });

  watch(config.templates, function () {
    browserSync.reload();
  });

});
