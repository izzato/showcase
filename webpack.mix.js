const mix = require('laravel-mix');

mix
    .js('resources/js/app.js', 'public/js').vue()
    .scripts([
        'resources/js/theme/jquery.app.js',
        'resources/js/theme/main.js'
    ], 'public/js/theme.js')
    .sass('resources/scss/main.scss', 'public/css/app.css');

if (mix.inProduction()) {
    mix.version();
}