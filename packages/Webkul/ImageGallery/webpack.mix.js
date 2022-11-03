const mix = require("laravel-mix");

if (mix == 'undefined') {
    const { mix } = require("laravel-mix");
}

require("laravel-mix-merge-manifest");

if (mix.inProduction()) {
    // var publicPath = 'publishable/assets';
    var publicPath = '../../../public/themes/pura_theme/assets';
} else {
    var publicPath = '../../../public/themes/pura_theme/assets';
}

mix.setPublicPath(publicPath).mergeManifest();
mix.disableNotifications();

mix.js([__dirname + '/src/Resources/assets/js/app.js'], 'js/app.js')
    .copyDirectory(__dirname + '/src/Resources/assets/images', publicPath + "/images/image-gallery")
    .sass(__dirname + '/src/Resources/assets/sass/admin.scss', 'css/image-gallery/admin.css')
    .sass(__dirname + '/src/Resources/assets/sass/default.scss', 'css/image-gallery/default.css')
    .sass(__dirname + '/src/Resources/assets/sass/velocity.scss', 'css/image-gallery/velocity.css')
    .sass(__dirname + '/src/Resources/assets/sass/imagegallery.scss', 'css/image-gallery/imagegallery.css')
    .options({
        processCssUrls: false
    });


if (! mix.inProduction()) {
    mix.sourceMaps();
}

if (mix.inProduction()) {
    mix.version();
}