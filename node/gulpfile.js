//REACT
const gulp = require('gulp');
const watch = require('gulp-watch');
const sourcemaps = require('gulp-sourcemaps');
const babel = require('gulp-babel');
const concat = require('gulp-concat');

gulp.task('default', function () {
    return gulp.src('./react/**.*')
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: ['@babel/env', '@babel/react']
        }))
        .pipe(concat('react.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./public/javascripts/react'))
});

gulp.task('stream', function () {
    // Endless stream mode
    return watch('./react/**.*', { ignoreInitial: false })
         .pipe(gulp.dest('./public/javascripts/react'));
});

gulp.task('callback', function () {
    return gulp.src('./react/**.*')
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: ['@babel/env', '@babel/react']
        }))
        .pipe(concat('react.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./public/javascripts/react'))
});
