const gulp = require('gulp'),
      sass = require('gulp-sass'),
      sourcemaps = require('gulp-sourcemaps');


gulp.task('sass', () => {
    gulp.src('./web/sass/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./web/css'));
});

//Watch task
gulp.task('default', () => {
    gulp.watch('web/sass/**/*.scss',['sass']);
});
