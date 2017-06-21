var gulp           = require('gulp'),
    gutil          = require('gulp-util' ),
    scss           = require('gulp-sass'),
    browserSync    = require('browser-sync'),
    concat         = require('gulp-concat'),
    uglify         = require('gulp-uglify'),
    cleanCSS       = require('gulp-clean-css'),
    rename         = require('gulp-rename'),
    del            = require('del'),
    imagemin       = require('gulp-imagemin'),
    cache          = require('gulp-cache'),
    autoprefixer   = require('gulp-autoprefixer'),
    bourbon        = require('node-bourbon'),
    ftp            = require('vinyl-ftp'),
    gcmq           = require('gulp-group-css-media-queries'),
    notify         = require("gulp-notify"),
    
    currentTheme   = 'zerotheme';

// Скрипты проекта
gulp.task('scripts', function() {
	return gulp.src([
        'wp-content/themes/' + currentTheme + '/js/**/*.js',
        '!wp-content/themes/' + currentTheme + '/js/**/*.min.js'
    ])
	.pipe(concat('script.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('wp-content/themes/' + currentTheme + '/js'));
});

// Стили проекта
gulp.task('scss', function() {
	return gulp.src('wp-content/themes/' + currentTheme + '/*.scss')
	.pipe(scss({
		includePaths: bourbon.includePaths
	}).on("error", notify.onError()))
	.pipe(rename({suffix: '.min', prefix : ''}))
	.pipe(autoprefixer(['last 15 versions']))
	.pipe(gcmq())
	.pipe(cleanCSS())
	.pipe(gulp.dest('wp-content/themes/' + currentTheme));
});

gulp.task('watch', ['scss', 'scripts'], function() {
	gulp.watch('wp-content/themes/' + currentTheme + '/*.scss', ['scss']);
	gulp.watch('wp-content/themes/' + currentTheme + '/js/**/*.js', ['scripts']);
    gulp.watch('wp-content/themes/' + currentTheme + '/**/*.php', ['scripts', 'scss']);
});