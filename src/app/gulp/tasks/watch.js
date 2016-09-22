var gulp = require('gulp');
var config = require('../config');
var watch = require('gulp-watch');
var sass = require('../config/sass');
//var browserSync = require('browser-sync');

gulp.task('watch', function () {

  watch(sass.src, function () {
    gulp.start('sass:development');
  });


  //watch(config.templates, function () {
  //  browserSync.reload();
  //});

});
