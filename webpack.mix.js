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

 mix.js('resources/js/app.js', 'public/js')
 .vue(3)
 .extract()
 .sass("resources/scss/config/default/app.scss", "public/css")
 .sass("resources/scss/config/default/bootstrap.scss", "public/css")
 .sass("resources/scss/icons.scss", "public/css")
 .alias({
     '@': 'resources/js',
 })
 .version();