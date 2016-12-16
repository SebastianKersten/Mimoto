var config = require('../config/sass');

var gulp = require('gulp');
var sass = require('gulp-sass');
var rename = require('gulp-rename');
var size = require('gulp-size');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var browserSync = require('browser-sync');

gulp.task('sass:development', function () {

  sassTasks('development');

});

gulp.task('sass:production', function () {

  sassTasks('production');

});

function sassTasks (env) {

  return gulp.src(config.src)
    .pipe(sass(config.settings)
    .on('error', sass.logError))
    .pipe(postcss(processors[env]))
    .pipe(rename({
      dirname: "",
      suffix: ""
    }))
    .pipe(gulp.dest(config.dest))
    .pipe(browserSync.reload({stream: true}));

}

var processors = {

  "development": [
    autoprefixer({browsers: ['last 10 version']})
  ],

  "production": [
    autoprefixer({browsers: ['last 10 version']})
  ]

};
