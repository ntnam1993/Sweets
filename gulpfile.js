var path = require('path');
var fs = require('fs');
var gulp = require('gulp');
var cssmin = require("gulp-cssmin");
var jsmin = require("gulp-jsmin");
var rename = require("gulp-rename");
var watch = require("gulp-watch");
var imagemin = require('gulp-imagemin');
var concat = require('gulp-concat');
var elixir = require('laravel-elixir');
var exec = require('child_process').exec;
var rev = require('gulp-rev');
var sass = require('gulp-sass');
var sequence = require('run-sequence');
var scriptsPath = 'public/assets';

function getFolders(dir) {
  return fs.readdirSync(dir)
    .filter(function(file) {
      return fs.statSync(path.join(dir, file)).isDirectory();
    });
}

gulp.task('jsmin', function() {
  var folders = getFolders(scriptsPath);
  var tasks = folders.map(function(folder) {
    return gulp.src(
        [
          path.join(scriptsPath, folder, '/**/*.js'),
          '!' + path.join(scriptsPath, folder, '/**/*.min.js')
        ]
      )
      .pipe(jsmin())
      .pipe(rename({ suffix: '.min' }))
      .pipe(gulp.dest(scriptsPath + '/' + folder));
  });
});

gulp.task("cssmin", function() {
  var folders = getFolders(scriptsPath);
  var tasks = folders.map(function(folder) {
    return gulp.src(
        [
          path.join(scriptsPath, folder, '/**/*.css'),
          path.join(scriptsPath, folder, '/css/owl.carousel.css'),
          '!' + path.join(scriptsPath, '/css/*.css'),
          '!' + path.join(scriptsPath, folder, '/**/*.min.css'),
          path.join(scriptsPath, folder, '/**/rateit.css')
        ]
      )
      .pipe(cssmin())
      .pipe(rename({ suffix: '.min' }))
      .pipe(gulp.dest(scriptsPath + '/' + folder));
  });
});

gulp.task("cssalltopsp", function() {
  var folders = getFolders(scriptsPath);
  var tasks = folders.map(function(folder) {
    return gulp.src(
        [
          'public/assets/mobile/css/bootstrap.min.css',
          'public/assets/css/owl.carousel.min.css',
          'public/assets/mobile/css/sp.css',
          'public/assets/mobile/css/custom.css',
          'public/assets/scss/sp.min.css',
        ]
      )
      .pipe(concat({path: 'index.css', cwd: ''}))
      .pipe(cssmin())
      .pipe(rename({ suffix: '.min' }))
      .pipe(gulp.dest('public/assets/mobile/css'));
  });
});

gulp.task("cssalltoppc", function() {
  gulp.src(
      [
        'public/assets/pc/css/bootstrap.min.css',
        'public/assets/css/owl.carousel.min.css',
        'public/assets/dist/css/lightbox.min.css',
        'public/assets/pc/css/pc.css',
        'public/assets/pc/css/custom.css',
        'public/assets/pc/css/custom-pc.css',
        'public/assets/scss/pc.min.css',
      ]
    )
    .pipe(concat({path: 'index.css', cwd: ''}))
    .pipe(cssmin())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('public/assets/pc/css'));
});

gulp.task("cssminowlcarousel", function() {
  var folders = getFolders(scriptsPath);
  gulp.src(['public/assets/css/owl.carousel.css', '!public/assets/css/owl.carousel.min.css'])
    .pipe(cssmin())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('public/assets/css'));
});

gulp.task('imagemin', function() {
  var folders = getFolders(scriptsPath);
  var tasks = folders.map(function(folder) {
    return gulp.src(
        [
          path.join(scriptsPath, folder, '/**/images/*'),
          path.join(scriptsPath, folder, '/**/images/img/*')
        ]
      )
      .pipe(imagemin())
      .pipe(gulp.dest(scriptsPath + '/' + folder));
  });
});

gulp.task('watch', function() {
  gulp.watch([path.join(scriptsPath, '/pc/**/*.css'), '!' + path.join(scriptsPath, '/pc/**/*.min.css')], ['cssmin', 'versioning']);
  gulp.watch([path.join(scriptsPath, '/mobile/**/*.css'), '!' + path.join(scriptsPath, '/mobile/**/*.min.css')], ['cssmin', 'versioning']);
  gulp.watch('resources/assets/sass/**/*.scss', ['scss']);

  var folders = getFolders(scriptsPath);
  var tasks_js = folders.map(function(folder) {
    return gulp.watch([path.join(scriptsPath, folder, '/**/*.js'), '!' + path.join(scriptsPath, folder, '/**/*.min.js')], ['jsmin', 'versioning']);
  });

  gulp.watch(
    [
      'public/assets/mobile/css/sp.css',
      'public/assets/mobile/css/custom.css',
      'public/assets/scss/sp.min.css'
    ], ['cssalltopsp', 'versioning']);

  gulp.watch(
    [
      'public/assets/pc/css/pc.css',
      'public/assets/pc/css/custom.css',
      'public/assets/pc/css/custom-pc.css',
      'public/assets/scss/pc.min.css'
    ], ['cssalltoppc', 'versioning']);
});

gulp.task('versioning', function() {

  var files = [
    'public/assets/pc/css/index.min.css',
    'public/assets/pc/css/pc.min.css',
    'public/assets/pc/css/custom.min.css',
    'public/assets/pc/css/custom-pc.min.css',

    'public/assets/mobile/css/custom.min.css',
    'public/assets/mobile/css/sp.min.css',
    'public/assets/mobile/css/index.min.css',

    'public/assets/pc/js/script.min.js',
    'public/assets/js/script.min.js',

    'public/assets/scss/pc.min.css',
    'public/assets/scss/sp.min.css',
  ];

  gulp.src(files, {base: 'public'})
    .pipe(rev())
    .pipe(gulp.dest('public/build'))
    .pipe(rev.manifest())
    .pipe(gulp.dest('public/build'));

  gulp.src('public/assets/images/**/*')
    .pipe(gulp.dest('public/build/images'));

  gulp.src('public/assets/pc/images/**/*')
    .pipe(gulp.dest('public/build/assets/pc/images'));

  gulp.src('public/assets/mobile/images/**/*')
    .pipe(gulp.dest('public/build/assets/mobile/images'));

});

gulp.task('scss', function () {

  return gulp.src('resources/assets/sass/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(cssmin())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('public/assets/scss'));

});
gulp.task('generate-service-worker', function(callback) {
    var swPrecache = require('sw-precache');
    var rootDir = 'public';
    swPrecache.write(`${rootDir}/service-worker.js`, {
        staticFileGlobs: [
            rootDir + '/build/assests/**/*.{js,css}',
            rootDir + '/build/images/**/*.{jpg,png,svg}',
            rootDir + 'resources/views/shop/mobile/shop-search.blade.php'
        ],
        dynamicUrlToDependencies: {
            '/shopsearch': ['resources/views/shop/mobile/shop-search.blade.php']
        },
        stripPrefix: rootDir
    }, callback);
});

gulp.task('clean-build', function () {
  exec('rm -rf ./public/build');
});

gulp.task('default', function () {
  sequence('clean-build', 'jsmin', 'scss', 'generate-service-worker', 'cssmin', 'cssminowlcarousel', 'cssalltopsp', 'cssalltoppc', function () {
    setTimeout(function () {
      gulp.start('versioning');
    }, 1000);
  });
});
