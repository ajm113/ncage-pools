'use strict';                                           // We use strict mode for better interpratation, and make the file less error prone.

const   gulp = require('gulp'),                         // Used to generate tasks.
        browserify = require('browserify'),             // Bundle our JavaScript.
        sass = require('gulp-sass'),                    // Convert our Sass to CSS.
        sourcemaps = require('gulp-sourcemaps'),        // Generates sourcemaps of our assets.
        plumber = require('gulp-plumber'),              // Keeps our tasks in piped regardless if error.
        autoprefixer = require('gulp-autoprefixer'),    // Autoprefix our CSS for multiple browsers.
        eslint = require('gulp-eslint'),                // Check our JavaScript for consistency and errors.
        rename = require('gulp-rename'),                // Rename our bundled JavaScript to bundle.js
        buffer = require('vinyl-buffer'),               // Used to convert our Browserify generated file into a steam for Gulp.js
        source = require('vinyl-source-stream'),        // Convert text streams at the start of gulp pipelines, making for nicer interoperability.
        uglify = require('gulp-uglify'),                // Minify JavaScript for performance and bandwidth.
        args = require('yargs').argv,                   // Needed to fetch command line arguments given to us.
        scsslint = require('gulp-scss-lint'),           // Check for Sass errors or anything that would hurt performance.
        gulpif = require('gulp-if'),                    // Make sure the task runner follows certain conditions depending on build.
        gutil = require('gulp-util'),                   // Helps with error routing inside our pipelines for our tasks.
        config = require('./gulpconfig.json');          // Our configuration file for tasks.

const isProduction = (args.production === undefined) ? false : true; // Check if we are building for production using: --production
const isDebug = (isProduction) ? false : true;                       // Check if we are simply doing debug build, helps make our conditionals cleaner.

gulp.task('babel', function() {

    let b = browserify({                // Get API access to Browserify for transformations.
        entries: config.babel.input,    // Our entry.js file.
        debug: isDebug                  // Display any errors we may want to see.
    });

    b.transform('babelify');                    // Convert our Babel code to JavaScript.

    return b.bundle()                           // Bundle all our converneted JavaScript into one source.
    .pipe(source('bundle.js'))                  // Tells the filename of the stream we want to write to.
    .pipe(buffer())                             // Bundle our converted JavaScript code into a stream for pipeline.
    .pipe(gulpif(isDebug, sourcemaps.init({loadMaps: true}))) // Generate a sourcemap file for better analysis and debugging.
        // Add transformation tasks to the pipeline here. uglify, linting, etc...
        .pipe(uglify())                             // Convert our code into minification for better performance and bandwidth.
        .on('error', gutil.log)                     // Routes any error messages to the console and continues our task manager like normal.
    .pipe(gulpif(isDebug, sourcemaps.write('./')))  // Write a sourcemap file in the same destination.
    .pipe(gulp.dest(config.babel.output));          // Write the compiled JavaScript to the destination for our browser.
});

gulp.task('sass', function() {
    return gulp.src(config.sass.input)              // Set the source of our Sass files for compilation.
        .pipe(plumber())                            // Initialize plumber for error routing or unexpected issues, so our task manager can continue like normal.
        .pipe(gulpif(isDebug, sourcemaps.init()))   // Initialize sourcemap for future analysis if debug enabled.
        .pipe(sass(config.sass.options).on('error', gutil.log)) // Set the error event route to our log util for Gulp.
        .pipe(autoprefixer(config.autoprefixer.options))        // Autoprefix our CSS for major browser support.
        .pipe(gulpif(isDebug, sourcemaps.write('./')))          // Write our our sourcemap file for analysis.
        .pipe(gulp.dest(config.sass.output));                   // Set the output directory for our browser to load our compile CSS.
});

gulp.task('images', function(){
    return gulp.src(config.images.input)            // Select the source of our images to copy into the correct directory.
        .pipe(gulp.dest(config.images.output));     // Set the destination of the directory for our browser to render.
});


gulp.task('watch', function () {
    gulp.watch([config.babel.input], ['babel']);    // Watch for any changes in JavaScript.
    gulp.watch([config.sass.input], ['sass']);      // Watch for any changes for our Sass.
    gulp.watch([config.images.input], ['images']);  // Watch for any changes in the images.
});

gulp.task('default', ['babel', 'sass', 'images']); // Default will build everything automatically.
