let mix = require('laravel-mix');

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

// mix.js('resources/assets/js/app.js', 'public/themes/pura_theme/assets/js').version();

mix.sass('resources/assets/sass/app.scss', 'public/themes/pura_theme/assets/css').version();

mix.js('resources/assets/js/firebase-messaging-sw.js', 'public').version();

mix.browserSync('http://127.0.0.1:8000');


