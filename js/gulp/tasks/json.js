var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    json_minify = require('gulp-jsonminify'),
    config = require('../config');

gulp.task(
    'json',
    function () {
        return gulp.src(config.minify_and_migrate.json)
            .pipe(plumber())
            .pipe(json_minify())
            .pipe(gulp.dest(config.output.js_mnm));
    }
);