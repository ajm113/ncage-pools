'use strict';

const gulp   = require('gulp'),                     // Our basic gulp API for our JavaScript to run tasks or watch for changes.
    sass   = require('gulp-sass'),                  // Convert our Sass to CSS for better quality code.
    uglify = require('gulp-uglify'),                // Change our converted babel code into minification since Babel doesn't do this.
    del = require('del'),                           // Clean up our output asset file for front-end.
    gulpif = require('gulp-if'),                    // Deals with if conditions for piping.
    changed = require('gulp-changed'),              // Checks if we need to continue with the build process of xyz files.
    sourcemaps = require('gulp-sourcemaps'),        // Generates sourcemap files for our CSS/JS.
    plumber = require('gulp-plumber'),              // Create plumber instance for our Babel/CSS code.
    scsslint = require('gulp-scss-lint'),           // Check for any Sass/Scss related errors we may want to know about.
    autoprefixer = require('gulp-autoprefixer'),    // Autoprefix our CSS for browsers that may not like certain CSS attributes.
    args = require('yargs').argv,                   // Handle our input arguments for Gulp.
    babel = require('gulp-babel'),                  // Convert our ES2015 code into vanilla cross browser friendly JavaScript.
    config = require('./gulpfile-config.json');     // Configuration file for our Gulp task manager in a nice place for easy configuration.

var isProduction = (args.production === undefined) ? false : true; // Check if we are running on --production if we want to ignore creating source-maps.
var isDebug = (isProduction) ? false : true;                       // Simply used to help keep our gulp-ifs clean.

gulp.task('clean', () => {
	return del([config.del.input], {force: true}).then(paths => {
    	console.log('Deleted files and folders:\n', paths.join('\n'));     // Nifty little function that prints our what files we deleted. (Nothing special about this.)
	});
});

gulp.task('img', () => {
    return gulp.src(config.img.input)           // Fetch the source of our images.
	.pipe(changed(config.img.output))           // Check for any changes before blindly copying them over. -- Save the cycles!
	.pipe(gulp.dest(config.img.output));        // Copy location of our images to help things consistent.
});

gulp.task('js', ()=> {
    return gulp.src(config.js.input)                                // Source location of our Babel code.
	.pipe(plumber())                                                // Create plumber to continue process even an event of an error.
    .pipe(gulpif(isDebug, sourcemaps.init()))                       // Initialize our sourcemap just encase we need to debug anything.
    .pipe(babel())                                                  // Convert our es2015 code into readable JavaScript for every browser.
    .pipe(gulpif(isDebug, uglify()))                                // Since Babel doesn't do this, we need to use Uglify in this case to keep our JS small.
    .pipe(gulpif(isDebug, sourcemaps.write('./')))                  // Output the sourcemap file when debugging issues.
	.pipe(gulp.dest(config.js.output));                             // Spit our our newly created JavaScript files!
});

gulp.task('js-vendors', ()=> {
    return gulp.src(config.vendorsjs.input)                         // We don't want to bundle everything, since HTTP/2 handles smaller file chunks better then HTTP 1.x.
    .pipe(changed(config.js.output))
    .pipe(gulp.dest(config.vendorsjs.output))                       // Sorry, bundle-boys, bundling isn't necessary anymore.
});

gulp.task('scss', ()=> {
    return gulp.src(config.scss.input)                              // Input all of our entry Sass files for compilation.
	.pipe(plumber())                                                // We want to avoid processing killing by node-sass, so we use plumber.
	.pipe(gulpif(isDebug, sourcemaps.init()))                       // Create a initial sourcemap entry point for debugging in the browser.
	.pipe(sass(config.scss.options).on('error', sass.logError))     // Convert our Scss to CSS for the browser.
    .pipe(autoprefixer({                                            // Autoprefix our CSS code for browser vendors that may not accept normal CSS attributes yet.
        browsers: ['last 2 versions'],
        cascade: false
    }))
    .pipe(gulpif(isDebug, sourcemaps.write('./')))                      // Output a sourcemap file for debugging in the browser.
	.pipe(gulp.dest(config.scss.output));                               // Output the generated CSS.
});

gulp.task('scss-lint', () => {
    return gulp.src(config.scss.input)   // Collect all of our Scss code
	.pipe(scsslint(config.scsslint.options));                   // Find any minor to major errors in our code we should be following!
});

gulp.task('watch', ()=> {
    gulp.watch(config.img.input, ['img']);
    gulp.watch(config.js.input, ['js']);
    gulp.watch(config.scss.input, ['scss']);
});


gulp.task('default', () => {
    gulp.start('scss', 'img', 'js', 'js-vendors', 'scss-lint');
});
