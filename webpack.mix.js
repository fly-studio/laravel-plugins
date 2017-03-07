const { mix } = require('laravel-mix');
mix.autoload({});
mix.config.publicDir = './';
mix.config.publicPath = './';
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

mix.js('static/js/catalog/catalog.node.js', 'static/js/catalog/catalog.min.js');
mix.js('static/js/link/action.node.js', 'static/js/link/action.min.js');