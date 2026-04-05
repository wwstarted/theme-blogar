const gulp = require('gulp');
const strip = require('gulp-strip-comments');
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify');

gulp.task('clean-php', () => {
  return gulp.src('**/*.php')
    .pipe(strip())
    .pipe(gulp.dest('dist'));
});

gulp.task('clean-css', () => {
  return gulp.src('**/*.css')
    .pipe(strip())
    .pipe(cleanCSS())
    .pipe(gulp.dest('dist'));
});

gulp.task('clean-js', () => {
  return gulp.src('**/*.js')
    .pipe(strip())
    .pipe(uglify())
    .pipe(gulp.dest('dist'));
});

gulp.task('default', gulp.parallel('clean-php', 'clean-css', 'clean-js'));