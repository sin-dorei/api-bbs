const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .version()
  .copyDirectory('node_modules/tinymce/tinymce.js', 'public/js/tinymce/tinymce.js')
  .copyDirectory('node_modules/tinymce-i18n/langs/zh_CN.js', 'public/js/tinymce/langs/zh_CN.js')
  .copyDirectory('node_modules/tinymce/icons', 'public/js/tinymce/icons')
  .copyDirectory('node_modules/tinymce/plugins', 'public/js/tinymce/plugins')
  .copyDirectory('node_modules/tinymce/skins', 'public/js/tinymce/skins')
  .copyDirectory('node_modules/tinymce/themes', 'public/js/tinymce/themes');
