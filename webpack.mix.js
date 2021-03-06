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

mix.js('resources/assets/js/app.js', 'public/js')
    .extract(['leaflet','bootstrap'])
    .less('resources/assets/less/app.less', 'public/css').version()
    .copy('resources/assets/css/leaflet.css', 'public/css')
    .copy('resources/assets/js/leaflet.js', 'public/js')
    .scripts(['resources/assets/js/jrl.js'], 'public/js/all.js').version();