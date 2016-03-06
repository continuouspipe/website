var gulp = require('gulp');
var compass = require('gulp-compass'),
    path = require('path');

gulp.task('compass', function() {
    gulp.src('./web/sass/*.scss')
        .pipe(compass({
            project: path.join(__dirname, 'web'),
            css: 'css',
            sass: 'sass'
        }))
        .pipe(gulp.dest('web/css'));
});


//Watch task
gulp.task('default',function() {
    gulp.watch('web/sass/**.scss',['compass']);
});
