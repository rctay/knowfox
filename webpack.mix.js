const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .js('resources/assets/js/ui.js', 'public/js')
   .copy('node_modules/reveal/index.js', 'public/js/reveal.js')
   .copy('node_modules/reveal/index.css', 'public/css/reveal.css')
   .copy('node_modules/reveal/theme', 'public/css/reveal-theme');
