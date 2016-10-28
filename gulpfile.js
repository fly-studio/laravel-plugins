var gulp = require('gulp');
var path = require('path');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var header = require('gulp-header');
var rename = require('gulp-rename');
var jshint = require('gulp-jshint');
var data = require('gulp-data');
var stripDebug = require('gulp-strip-debug');
var minifyCss = require('gulp-minify-css');
//var vinylPaths = require('vinyl-paths');
var del = require('del');

// 分散压缩
gulp.task('watch', function() {
    gulp.watch(['static/js/**/*.js','static/css/**/*.css', '!static/js/**/*.min.js', '!static/css/**/*.min.css'], function(e){
        var ext = path.extname(e.path);
        var dir = path.dirname(e.path);
        if (e.type == 'deleted')
        {
          var filename = path.basename(e.path, ext);
          del.sync(path.join(dir,filename+'.min'+ext));
        }
        else
        {   switch (ext.toLowerCase())
            {
                case '.js':
                    gulp.src(e.path)
                    .pipe(data(function (file) {
                        return {
                            filename: path.basename(file.path),
                            dir: path.dirname(file.path)
                        };
                    }))
                    .pipe(uglify({output: {ascii_only:true}}))
                    .pipe(header('/*! ${filename} ${date}*/\n', { date : (new Date).toLocaleString()} ))
                    .pipe(rename({suffix:'.min'}))
                    .pipe(gulp.dest(dir));
                    break;
                case '.css':
                    gulp.src(e.path)
                    .pipe(data(function (file) {
                        return {
                            filename: path.basename(file.path),
                            dir: path.dirname(file.path)
                        };
                    }))
                    .pipe(minifyCss())
                    .pipe(header('/*! ${filename} ${date}*/\n', { date : (new Date).toLocaleString()} ))
                    .pipe(rename({suffix:'.min'}))
                    .pipe(gulp.dest(dir));
                    break;
            }
        }
    });
});
// 默认任务
gulp.task('default', ['watch']);
