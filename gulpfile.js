const sass = require('gulp-sass'),
      sourcemaps = require('gulp-sourcemaps');

const { src, dest, task, watch } = require('gulp');

const compileSass = function(callback) {
  src('./web/sass/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(dest('./web/css'));
  callback();
}
compileSass.displayName = 'sass';

task(compileSass);

// Watch task
const watchSass = function(callback) {
  watch(['web/sass/**/*.scss'], function(callback) {
    sass(callback);
    callback();
  });
}
watchSass.displayName = 'watch';
task(watchSass);

exports.default = watchSass
