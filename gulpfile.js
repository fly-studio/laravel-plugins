var gulp = require('gulp');
var path = require('path');
var util = require("gulp-util");
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var header = require('gulp-header');
var rename = require('gulp-rename');
var jshint = require('gulp-jshint');
var csslint = require('gulp-csslint');
var data = require('gulp-data');
var minifyCss = require('gulp-minify-css');
var del = require('del');
var map = require('map-stream');

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
                    .pipe(jshint({loopfunc:true}))
                    .pipe(map(function (file, cb) {
                        if (file.jshint.success) {
                            util.log('0 error. JSHINT success!');
                            return cb(null, file);
                        }
                        util.log('JSHINT fail in', file.path);
                        let i = 0;
                        file.jshint.results.forEach(function (result) {
                            if (!result.error)
                                return;
                            i++;
                            const err = result.error
                            util.log(`  line ${err.line}, col ${err.character}, code ${err.code}, ${err.reason}`);
                        });
                        util.log(i + ' errors.');
                        
                        //return cb();
                    }))
                    .pipe(data(function (file) {
                        return {
                            filename: path.basename(file.path),
                            dir: path.dirname(file.path)
                        };
                    }))
                    .pipe(uglify({output: {ascii_only:true}}))
                    .pipe(header('/*! ${filename} ${date}*/\n', { date : (new Date).toLocaleString()} ))
                    .pipe(rename({suffix:'.min'}))
                    .pipe(gulp.dest(dir))
                    .pipe(map(function(file, cb){
                        util.log('created ', file.path);
                        return cb(null, file);
                    }));
                    break;
                case '.css':
                    gulp.src(e.path)
                    .pipe(csslint())
                    .pipe(csslint.formatter())
                    .pipe(data(function (file) {
                        return {
                            filename: path.basename(file.path),
                            dir: path.dirname(file.path)
                        };
                    }))
                    .pipe(minifyCss())
                    .pipe(header('/*! ${filename} ${date}*/\n', { date : (new Date).toLocaleString()} ))
                    .pipe(rename({suffix:'.min'}))
                    .pipe(gulp.dest(dir))
                    .pipe(map(function(file, cb){
                        util.log('created ', file.path);
                        return cb(null, file);
                    }));
                    break;
            }
        }
    });
});
// 默认任务
gulp.task('default', ['watch']);
