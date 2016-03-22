var gulp = require('gulp'),
    watch = require('gulp-watch'),
    run = require('../util/run'),
    config = require('../config');

gulp.task(
    'watch',
    function () {
        watch(_allCss(), run.sequence('css'));
        watch(_allJs(), run.sequence('js'));
        watch(_allJson(), run.sequence('json'));
    }
);

function _wrap(arr) {
    return '(' + arr.join('|') + ')';
}

function _allCss() {
    var op = [];
    for (var key in config.builds) {
        if (config.builds.hasOwnProperty(key)) {
            op = op.concat(config.builds[key].css, config.builds[key].vendor_css);
        }
    }
    return _wrap(op.concat(config.minify_and_migrate.css));
}

function _allJs() {
    var op = [];
    for (var key in config.builds) {
        if (config.builds.hasOwnProperty(key)) {
            op = op.concat(config.builds[key].js, config.builds[key].vendor_js);
        }
    }
    return _wrap(op.concat(config.minify_and_migrate.js));
}

function _allJson() {
    return _wrap(config.minify_and_migrate.json);
}
