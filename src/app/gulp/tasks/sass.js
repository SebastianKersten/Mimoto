var config = require('../config/sass');

var gulp = require('gulp');
var sass = require('gulp-sass');
var rename = require('gulp-rename');
var size = require('gulp-size');

gulp.task('sass', function () {

  return gulp.src(config.src)
    .pipe(sass(config.settings).on('error', sass.logError))
    .pipe(rename(config.cssName))
    .pipe(gulp.dest(config.dest))
    .pipe(size({title:config.cssName}));

});
