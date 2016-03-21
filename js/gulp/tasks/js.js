var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    compress = require('gulp-yuicompressor'),
    concat = require('gulp-concat'),
    es = require('event-stream'),
    rename = require('gulp-rename'),
    filter = require('gulp-filter'),
    config = require('../config');

gulp.task(
    'js',
    function () {
        // Builds
        var streams = [];
        for (var build_name in config.builds) {
            if (config.builds.hasOwnProperty(build_name)) {
                var build = config.builds[build_name],
                    stream = gulp.src([].concat(build.vendor_js, build.js))
                        .pipe(plumber())
                        .pipe(concat(build_name + '.min.js'))
                        .pipe(compress({type: 'js'}))
                        .pipe(gulp.dest(config.output.js_build));
                streams.push(stream);
            }
        }

        //Legacy single serving files (to be refactored into builds or deleted)
        var uniminified = filter(['**', '!**/*.min.js', '!**/JSXTransformer.js'], {restore: true});
        streams.push(
            gulp.src(config.minify_and_migrate.js)
                .pipe(plumber())
                .pipe(uniminified)
                .pipe(compress({type: 'js'}))
                .pipe(rename({suffix: '.min'}))
                .pipe(uniminified.restore)
                .pipe(gulp.dest(config.output.js_mnm))
        );

        return es.merge(streams);
    }
);