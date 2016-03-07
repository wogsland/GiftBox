var gulp = require('gulp'),
    stylus = require('gulp-stylus'),
    path = require('path'),
    concat = require('gulp-concat'),
    watch = require('gulp-watch'),
    run = require('./gulp/run'),
    rename = require('gulp-rename'),
    plumber = require('gulp-plumber'),
    order = require('gulp-order'),
    compress = require('gulp-yuicompressor'),
    es = require('event-stream'),

    paths = {
        css: [
            path.join('css', 'owl.theme.css'),
            path.join('css', 'owl.carousel.css'),
            path.join('css', 'nivo-lightbox.css'),
            path.join('css', 'font-awesome.min.css'),
            path.join('css', 'animate.css'),
            path.join('css', 'styles.css')
        ],
        stylus: [
            path.join('css', 'variables.styl'),
            path.join('css', 'Pricing.styl')
        ],
        js: [
            path.join('js', 'pricing.js'), 'js/test.js'
        ],
        css_build: path.join('public', 'css'),
        js_build: path.join('public', 'js')
    };

gulp.task(
    'css',
    function () {
        var css = gulp.src(paths.css);

        var styl = gulp.src(paths.stylus)
            .pipe(plumber())
            .pipe(concat('z.styl'))
            .pipe(stylus());

        return es.merge(css, styl)
            .pipe(plumber())
            .pipe(compress({type: 'css'}))
            .pipe(order(
                ['!z.styl', 'z.styl']
            ))
            .pipe(concat('styles.min.css'))
            .pipe(gulp.dest(paths.css_build));
    }
);

gulp.task(
    'js',
    function () {
        return gulp.src(paths.js)
            .pipe(plumber())
            .pipe(compress({type: 'js'}))
            .pipe(rename({
                suffix: '.min'
            }))
            .pipe(gulp.dest(paths.js_build));
    }
);

gulp.task(
    'develop',
    function () {
        watch("("+[].concat(paths.css).concat(paths.stylus).join("|")+")", run.sequence('css'));
        watch(paths.js.join("|"), run.sequence('js'));
    }
);
