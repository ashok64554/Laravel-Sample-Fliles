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

/*
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
   */

mix.styles([
    'public/assets/admin/css/bootstrap.min.css',
    'public/assets/admin/css/material.css',
    'public/assets/admin/css/style.css',
    'public/assets/admin/js/bootstrap-fileupload/bootstrap-fileupload.css',
    'public/assets/admin/css/signup.css'
], 'public/css/backend.css');

mix.scripts([
    'public/assets/admin/js/jquery-ui-1.10.3.custom.min.js',
    'public/assets/admin/js/materialize.js',
    'public/assets/admin/js/bootstrap.min.js',
    'public/assets/admin/js/jquery.nicescroll.min.js',
    'public/assets/admin/js/wow.min.js',
    'public/assets/admin/js/jquery.loadmask.min.js',
    'public/assets/admin/js/jquery.accordion.js',
    'public/assets/admin/js/bic_calendar.js',
    'public/assets/admin/js/core.js',
    'public/assets/admin/js/tooltip-custom.js',
    'public/assets/admin/js/jquery.countTo.js',
    'public/assets/admin/js/bootstrap-fileupload/bootstrap-fileupload.js',
    'public/assets/admin/js/jquery.dataTables.min.js',
    'public/assets/admin/js/bootstrap-datatables.js',
    'public/assets/admin/js/dataTables-custom.js',
    'public/assets/admin/js/ckeditor/ckeditor.js',
    'public/assets/admin/js/custom.js'
],  'public/js/backend.js');
