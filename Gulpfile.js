var gulp = require('gulp');
var concatCss = require('gulp-concat-css');
var watch = require('gulp-watch');

var css_src = 'Mimoto/userinterface/templates/Mimoto.CMS/**/*.css';

gulp.task('default', function () {
    gulp.watch(css_src, ['concatCss']);
});

gulp.task('concatCss', function () {
    return gulp.src(css_src)
        .pipe(concatCss('mimoto.cms.css'))
        // .on('error', function () {
        //     this.emit('end');
        // })
        .pipe(gulp.dest('web/static/css/'));
});