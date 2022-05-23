const path = require('path');
const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.alias({
  ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue'),
});

mix
  .js('resources/js/app.js', 'public/js')
  .vue({ version: 2 })
  .sass('resources/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false,
    postCss: [require('tailwindcss')()],
  });

mix.copyDirectory('resources/public/', 'public/');
mix.version().disableSuccessNotifications();
