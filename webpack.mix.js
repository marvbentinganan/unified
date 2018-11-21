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

mix.js("resources/assets/js/app.js", "public/js")
    .scripts([
        "public/plugins/sweetalert2/sweetalert2.all.js",
        "public/plugins/toastr/js/toastr.min.js"
    ], "public/js/all.js")
    .copy(
        "resources/assets/less/dist/semantic.min.css",
        "public/css/semantic-ui/semantic.min.css"
    )
    .copy(
        "node_modules/semantic-ui-css/semantic.min.js",
        "public/js/semantic-ui/semantic.min.js"
    );
//.sass('resources/assets/sass/app.scss', 'public/css')
//.less('resources/assets/less/src/semantic.less', 'public/css');
