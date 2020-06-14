let mix = require('laravel-mix');

require('mix-tailwindcss');
require('laravel-mix-purgecss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.postCss('assets/css/test.css', 'public/css')
    .tailwind()
    .purgeCss()
    .js('assets/js/app.js', 'public/js');
