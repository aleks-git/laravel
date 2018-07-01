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

mix.scripts([
    'resources/assets/js/staffs/jquery.min.js',
    'resources/assets/js/staffs/jquery-ui.js',
    'resources/assets/js/staffs/jquery-sortable.js',
    'resources/assets/js/staffs/custom.js'
], 'public/js/app.js')
   .styles([
       'resources/assets/css/staffs/bootstrap.min.css',
       'resources/assets/css/staffs/custom.css',
       'resources/assets/css/staffs/jquery-ui.css'
   ], 'public/css/app.css');
