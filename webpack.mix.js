const { mix } = require('laravel-mix');
mix.autoload({}).
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('static/js/catalog/catalog.js', 'static/js/catalog/catalog.min.js')
;
