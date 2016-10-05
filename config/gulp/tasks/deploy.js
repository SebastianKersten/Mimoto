var gulp = require('gulp');

gulp.task('deploy', ['sass:production', 'webpack:production']);
