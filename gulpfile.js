var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var cssnano = require('gulp-cssnano');

gulp.task('sass', function() {
    return gulp.src('./sass/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions']
        }))
        .pipe(cssnano())
        .pipe(gulp.dest('./web/'));
});

gulp.task('sass:watch', function() {
    gulp.watch('./**/*.scss', ['sass']);
});