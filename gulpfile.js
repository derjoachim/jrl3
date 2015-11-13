var gulp = require('gulp');
var elixir = require('laravel-elixir');
var jshint = require("gulp-jshint");
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */
gulp.task("lint", function() {
    gulp.src("./resources/assets/*.js")
        .pipe(jshint())
        .pipe(jshint.reporter("default"));
});

elixir(function(mix) {
    mix.less('app.less');
});

elixir(function(mix) {
    mix.scripts([
        'jrl.js'
    ]);
});

elixir(function(mix) {
    mix.version(['css/app.css', 'js/all.js']);
});

