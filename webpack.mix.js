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
  .copyDirectory('resources/editor/js', 'public/js')
  .copyDirectory('resources/editor/css', 'public/css')
  // .copyDirectory('node_modules/tinymce/tinymce.min.js', 'public/js/tinymce/tinymce.min.js')
  // .copyDirectory('node_modules/tinymce/icons/default/icons.min.js', 'public/js/tinymce/icons/default/icons.min.js')
  // .copyDirectory('node_modules/tinymce/skins/content/default/content.min.css', 'public/js/tinymce/skins/content/default/content.min.css')
  // .copyDirectory('node_modules/tinymce/skins/ui/oxide/content.min.css', 'public/js/tinymce/skins/ui/oxide/content.min.css')
  // .copyDirectory('node_modules/tinymce/skins/ui/oxide/skin.min.css', 'public/js/tinymce/skins/ui/oxide/skin.min.css')
  // .copyDirectory('node_modules/tinymce/themes/silver/theme.min.js', 'public/js/tinymce/langs/zh_CN.js')
  // .copyDirectory('node_modules/tinymce/plugins/image/plugin.min.js', 'public/js/tinymce/plugins/image/plugin.min.js')
  // .copyDirectory('node_modules/tinymce-i18n/langs/zh_CN.js', 'public/js/tinymce/langs/zh_CN.js')

