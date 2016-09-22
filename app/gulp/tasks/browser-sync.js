var config = require('../config/browser-sync');

var gulp = require('gulp');
var browserSync = require('browser-sync');

gulp.task('browserSync', function() {
  return browserSync(config);
});
