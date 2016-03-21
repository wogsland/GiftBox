var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    stylus = require('gulp-stylus'),
    concat = require('gulp-concat'),
    es = require('event-stream'),
    filter = require('gulp-filter'),
    rename = require('gulp-rename'),
    compress = require('gulp-yuicompressor'),
    config = require('../config');

gulp.task(
    'css',
    function() {
        // Builds
        var streams = [];

        for (var build_name in config.builds) {
            if (config.builds.hasOwnProperty(build_name)) {
                var build = config.builds[build_name],
                    styl_filter = filter('**/*.styl', {restore: true}),
                    stream = gulp.src([].concat(build.vendor_css, build.css))
                        .pipe(plumber())
                        .pipe(styl_filter)
                        .pipe(concat('bundled.styl'))
                        .pipe(stylus())
                        .pipe(styl_filter.restore)
                        .pipe(concat(build_name + '.min.css'))
                        .pipe(compress({type: 'css'}))
                        .pipe(gulp.dest(config.output.css_build));
                streams.push(stream);
            }
        }

        //Legacy single serving files (to be refactored into builds or deleted)
        var uniminified = filter(['**', '!**/*.min.js'], {restore: true});
        streams.push(
            gulp.src(config.minify_and_migrate.css)
                .pipe(plumber())
                .pipe(uniminified)
                .pipe(compress({type: 'css'}))
                .pipe(rename({suffix: '.min'}))
                .pipe(uniminified.restore)
                .pipe(gulp.dest(config.output.css_mnm))
        );

        return es.merge(streams);
    }
);