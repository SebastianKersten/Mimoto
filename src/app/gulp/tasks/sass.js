var gulp = require('gulp');
var sass = require('gulp-sass');
var config = require('../config/sass');

var rename = require('gulp-rename');

gulp.task('sass', function () {
  return gulp.src('./sass/**/*.scss')
    .pipe(sass(config.settings).on('error', sass.logError))
    .pipe(gulp.dest('./css'));

});