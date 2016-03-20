var gulp = require('gulp'),
    path = require('path'),
    /*stylus = require('gulp-stylus'),
    path = require('path'),
    concat = require('gulp-concat'),
    watch = require('gulp-watch'),
    run = require('./gulp/run'),
    rename = require('gulp-rename'),
    plumber = require('gulp-plumber'),
    order = require('gulp-order'),
    compress = require('gulp-yuicompressor'),
    json_minify = require('gulp-jsonminify'),
    polybuild = require('polybuild'),
    es = require('event-stream'),*/

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
            path.join('js', 'pricing.js')
        ],
        json: [
            path.join('js', 'api-v1.json')
        ],
        polymer: [
            'recruiting_token.php'
        ],
        legacy: {
            js: [
                path.join('js', 'smoothscroll.js'),
                path.join('js', 'wow.js'),
                path.join('js', 'create_common.js'),
                path.join('js', 'create_recruiting.js'),
                path.join('js', 'custom.js'),
                path.join('js', 'account.js'),
                path.join('js', 'matchMedia.js'),
                path.join('js', 'contact.js'),
                path.join('js', 'login.js'),
                path.join('js', 'signup.js')
            ],
            css: [
                path.join('css', 'colorbox.css'),
                path.join('css', 'magnific-popup.css'),
                path.join('css', 'create_recruiting.css'),
                path.join('css', 'datatables.css'),
                path.join('css', 'at-at.css'),
                path.join('css', 'ball-robot.css')
            ]
        },
        css_build: path.join('public', 'css'),
        js_build: path.join('public', 'js'),
        polymer_build: path.join('.')
    };

gulp.task(
    'css',
    function () {
        // Deps
        var plumber = require('gulp-plumber'),
            stylus = require('gulp-stylus'),
            concat = require('gulp-concat'),
            es = require('event-stream'),
            order = require('gulp-order'),
            rename = require('gulp-rename'),
            compress = require('gulp-yuicompressor');

        // Busniness time
        var css = gulp.src(paths.css),
            styl = gulp.src(paths.stylus)
                .pipe(plumber())
                .pipe(concat('z.styl'))
                .pipe(stylus()),

            styles = es.merge(css, styl),
            legacy = gulp.src(paths.legacy.css);

        legacy
            .pipe(plumber())
            .pipe(compress({type: 'css'}))
            .pipe(rename({suffix: '.min'}))
            .pipe(gulp.dest(paths.css_build));

        styles.pipe(plumber())
            .pipe(compress({type: 'css'}))
            .pipe(order(['!z.styl', 'z.styl']))
            .pipe(concat('styles.min.css'))
            .pipe(gulp.dest(paths.css_build));

        return es.merge(legacy, styles);
    }
);

gulp.task(
    'js',
    function () {
        // Deps
        var plumber = require('gulp-plumber'),
            rename = require('gulp-rename'),
            compress = require('gulp-yuicompressor');

        // Business time
        return gulp.src(paths.js.concat(paths.legacy.js))
            .pipe(plumber())
            .pipe(compress({type: 'js'}))
            .pipe(rename({
                suffix: '.min'
            }))
            .pipe(gulp.dest(paths.js_build));
    }
);

gulp.task(
    'json',
    function () {
        // Deps
        var plumber = require('gulp-plumber'),
            json_minify = require('gulp-jsonminify');

        // Business time
        return gulp.src(paths.json)
            .pipe(plumber())
            .pipe(json_minify())
            .pipe(gulp.dest(paths.js_build));
    }
);

gulp.task(
    'polybuild',
    function () {
        // Deps
        var plumber = require('gulp-plumber'),
            polybuild = require('polybuild'),
            filter =require('gulp-filter'),
            rename = require('gulp-rename'),
            es = require('event-stream'),
            replace = require('gulp-replace');

        // Business time
        var built = gulp.src(paths.polymer)
                .pipe(plumber())
                .pipe(polybuild({maximumCrush: true})),
            js = built.pipe(filter('*.js')),
            not_js = built.pipe(filter(['*', '!*.js']));

        // JS processing
        js
            .pipe(rename(function(path) {
                path.basename = path.basename.replace('.build', '.min')
            }))
            .pipe(gulp.dest(paths.js_build));

        // Markup processing
        not_js
            .pipe(replace(/(")([^"]+)(\.build\.js")/g, '"/js/$2.min.js"'))
            .pipe(replace('"fonts/', '"/fonts/'))
            .pipe(gulp.dest(paths.polymer_build));

        return es.merge(js, not_js);
    }
);

gulp.task(
    'develop',
    function () {
        // Deps
        var watch = require('gulp-watch'),
            run = require('./gulp/run');

        // Business time
        watch("("+[].concat(paths.css).concat(paths.stylus).join("|")+")", run.sequence('css'));
        watch(paths.js.join("|"), run.sequence('js'));
        watch(paths.json.join("|"), run.sequence('json'));
    }
);
