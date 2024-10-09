const mix = require('laravel-mix');
require('laravel-mix-jigsaw');

mix.disableSuccessNotifications();
mix.setPublicPath('source/assets/build');

mix
    // .jigsaw()
    .js('source/_assets/js/scripts.js', 'js')
    .sass('source/_assets/scss/style.scss', 'css')
    .options({
        processCssUrls: false,
    })
    .version();
