var gulp = require('gulp'),
    path = require('path'),
    p = PathHelper = {
        js: function (name) {
            return path.join('js', name + '.js');
        },
        vendor_js: function (name) {
            return p.js(path.join('vendor', name));
        },
        css: function (name) {
            return path.join('css', name + '.css');
        },
        vendor_css: function (name) {
            return p.js(path.join('vendor', name));
        }
    },
    paths = {
        css: [
            path.join('css', 'owl.theme.css'),
            path.join('css', 'owl.carousel.css'),
            path.join('css', 'font-awesome.min.css'),
            path.join('css', 'animate.css'),
            path.join('css', 'styles.css')
        ],
        stylus: [
            path.join('css', 'variables.styl'),
            path.join('css', 'Pricing.styl')
        ],
        builds: {
            api_documentation: {
                vendor_js: [
                    p.vendor_js('jquery.slideto.min'),
                    p.vendor_js('jquery.wiggle.min'),
                    p.vendor_js('jquery.ba-bbq.min'),
                    p.vendor_js('handlebars-2.0.0.min'),
                    p.vendor_js('highlight.7.3.pack'),
                    p.vendor_js('underscore-min'),
                    p.vendor_js('backbone-min'),
                    p.vendor_js('swagger-ui.min'),
                    p.vendor_js('highlight.7.3.pack'),
                    p.vendor_js('jsoneditor.min'),
                    p.vendor_js('marked.min'),
                    p.vendor_js('swagger.oath.min')
                ],
                vendor_css: [],
                js: [],
                css: []
            },
            marketing: {
                vendor_js: [
                    /** TODO: These should generally be pulled from one of the package manager directories **/
                    p.vendor_js('bootstrap.min'),
                    p.vendor_js('smoothscroll'),
                    p.vendor_js('jquery.scrollTo.min'),
                    p.vendor_js('jquery.localScroll.min'),
                    p.vendor_js('jquery-ui.min'),
                    p.vendor_js('simple-expand.min'),
                    p.vendor_js('wow'),
                    p.vendor_js('jquery.stellar.min'),
                    p.vendor_js('retina-1.1.0.min'),
                    p.vendor_js('matchMedia'),
                    p.vendor_js('jquery.ajaxchimp.min')
                ],
                vendor_css: [
                    path.join('css', 'owl.theme.css'),
                    path.join('css', 'owl.carousel.css'),
                    path.join('css', 'font-awesome.min.css'),
                    path.join('css', 'animate.css')
                ],
                js: [
                    p.js('custom'),
                    p.js('account'),
                    p.js('pricing')
                ],
                css: [
                    // Vanilla css
                    path.join('css', 'styles.css'),

                    // Stylus
                    path.join('css', 'variables.styl'),
                    path.join('css', 'Pricing.styl')
                ]
            },
            application: {
                vendor_js: [],
                vendor_css: [],
                js: [],
                css: []
            }
        },
        json: [
            path.join('js', 'api-v1.json')
        ],
        polymer: [
            'recruiting_token.php'
        ],
        legacy: {
            js: [
                p.vendor_js('react.min'),
                p.vendor_js('JSXTransformer'),
                p.js('create_common'),
                p.js('create_recruiting'),
                p.js('free-trial.min'),
                p.js('contact'),
                p.js('login'),
                p.js('signup')
            ],
            css: [
                path.join('css', 'create_recruiting.css'),
                path.join('css', 'datatables.css'),
                path.join('css', 'at-at.css'),
                path.join('css', 'ball-robot.css')
            ]
        },
        css_build: path.join('public', 'css'),
        js_build: path.join('public', 'js'),
        js_dist: path.join('public', 'js', 'dist'),
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

        // Business time
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
            compress = require('gulp-yuicompressor'),
            concat = require('gulp-concat'),
            es = require('event-stream'),
            rename = require('gulp-rename'),
            filter = require('gulp-filter');

        // Business time

        // Builds
        var streams = [];
        for (var build_name in paths.builds) {
            if (paths.builds.hasOwnProperty(build_name)) {
                var build = paths.builds[build_name],
                    stream = gulp.src([].concat(build.vendor_js, build.js))
                        .pipe(plumber())
                        .pipe(concat(build_name + '.min.js'))
                        .pipe(compress({type: 'js'}))
                        .pipe(gulp.dest(paths.js_dist));
                streams.push(stream);
            }
        }

        //Legacy single serving files (to be refactored into builds or deleted)
        var uniminified = filter(['**', '!**/*.min.js', '!**/JSXTransformer.js'], {restore: true});
        streams.push(
            gulp.src(paths.legacy.js)
                .pipe(plumber())
                .pipe(uniminified)
                .pipe(compress({type: 'js'}))
                .pipe(rename({suffix: '.min'}))
                .pipe(uniminified.restore)
                .pipe(gulp.dest(paths.js_build))
        );

        return es.merge(streams);
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
            .pipe(replace(/(")([^"]+)(\.build\.js")/g, '"/js/$.min.js"'))
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
