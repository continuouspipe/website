const gulp = require('gulp'),
      sass = require('gulp-sass');


gulp.task('sass', () => {
    gulp.src('./web/sass/**/*.scss')
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(gulp.dest('./web/css'));
});

//Watch task
gulp.task('default', () => {
    gulp.watch('web/sass/**/*.scss',['sass']);
});
