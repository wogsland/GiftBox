var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    polybuild = require('polybuild'),
    filter =require('gulp-filter'),
    rename = require('gulp-rename'),
    es = require('event-stream'),
    replace = require('gulp-replace'),
    config = require('../config'),
    fs = require('fs');

gulp.task(
    'polybuild',
    function () {
        var built = gulp.src(config.polybuild)
            .pipe(plumber())
            .pipe(polybuild({maximumCrush: true})),
            js = built.pipe(filter('*.js')),
            not_js = built.pipe(filter(['*', '!*.js']));

        // JS processing
        js
            .pipe(rename(function(path) {
                path.basename = path.basename.replace('.build', '.min');
            }))
            .pipe(gulp.dest(config.output.js_build));

        // Markup processing
        not_js
            .pipe(replace(/(")([^"]+)(\.build\.js")/g, '"/js/dist/$2.min.js?v='+fs.readFileSync('version', {encoding: 'utf8'}).trim()+'"'))
            .pipe(replace('"fonts/', '"/fonts/'))
            .pipe(gulp.dest(config.output.polybuild));

        return es.merge(js, not_js);
    }
);
