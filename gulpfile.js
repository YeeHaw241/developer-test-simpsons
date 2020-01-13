var source = require('vinyl-source-stream')
  , clean = require('gulp-clean')
  , gulp = require('gulp')
  , sass = require('gulp-sass')
  , postcss = require('gulp-postcss')
  , autoprefixer = require('autoprefixer')
  , browserify = require('browserify')
  , sourcemaps = require('gulp-sourcemaps')
  , rename = require('gulp-rename')
  , partialify = require('partialify')

// Paths

var resourcePath = './public/resources/'
  , buildPath = resourcePath + 'compiled/'
  , sassPath = resourcePath + 'sass/'
  , jsPath = resourcePath + 'javascript/'


// Build Sass

gulp.task('sass', gulp.series(cleanCss, function () {
    return gulp.src(sassPath + 'main.scss',{allowEmpty: true})
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed',
            includePaths: [
                './node_modules/bootstrap-sass/assets/stylesheets/'
            ]
        }))
        .pipe(postcss([ autoprefixer({ browsers: ['last 2 versions'] }) ]))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(buildPath + 'css/'))
}));

// Build JS

gulp.task('js', gulp.series(cleanJs, function (){
    return browserify({
            debug: true, // Generates sourcemaps
            entries: [jsPath + 'main.js']
        })
        .transform(partialify)
        .bundle()
        .pipe(source('main.js'))
        .pipe(gulp.dest(buildPath + 'js/'));
}));


// Copy images

gulp.task('copy:images', gulp.series(cleanImages, function() {
    return gulp.src(resourcePath + 'images/**',{allowEmpty: true})
        .pipe(gulp.dest(buildPath + 'images/'))
}));

// Copy fonts

gulp.task('copy:fonts', gulp.series(cleanFonts, function() {
    return gulp.src(resourcePath + 'fonts/**',{allowEmpty: true})
        .pipe(gulp.dest(buildPath + 'fonts/'))
}));

// Clean Fonts
function cleanFonts(){
    return gulp.src(buildPath + 'fonts', {
        read: false,
		allowEmpty: true,
    }).pipe(clean())
};

// Clean Images

function cleanImages(){
    return gulp.src(buildPath + 'images', {
        read: false,
		allowEmpty: true,
    }).pipe(clean())
};

// Clean CSS
function cleanCss(){
    return gulp.src(buildPath + 'css', {
        read: false,
		allowEmpty: true,
    }).pipe(clean())
};

// Clean JS
function cleanJs(){
    return gulp.src(buildPath + 'js', {
        read: false,
		allowEmpty: true,
    }).pipe(clean())
};

//Watch
gulp.task('watch', function () {
    gulp.watch(jsPath + '**', ['js']);
    gulp.watch(sassPath + '**', ['sass']);
});

// Default task

gulp.task('default', gulp.series('sass', 'js', 'copy:images', 'copy:fonts'));
