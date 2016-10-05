var gulp = require('gulp');

gulp.task('default', ['sass:development', 'webpack:development', 'watch', 'browserSync']);
