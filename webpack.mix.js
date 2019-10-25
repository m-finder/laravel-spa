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
    .js('resources/js/admin.js', 'public/js')
    .sass('resources/sass/admin.scss', 'public/css');

mix.listen('configReady', (webpackConfig) => {
    // Create SVG sprites
    webpackConfig.module.rules.unshift({
        test: /\.svg$/,
        loader: 'svg-sprite-loader',
        include: /(resources\/icons\/svg)/,
        options: {
            symbolId: 'icon-[name]',
        }
    });

    // Exclude 'svg' folder from font loader
    let fontLoaderConfig = webpackConfig.module.rules.find(rule => String(rule.test) === String(/\.(woff2?|ttf|eot|svg|otf)$/));
    fontLoaderConfig.exclude = /(resources\/icons\/svg)/;
});