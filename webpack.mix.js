const mix = require('laravel-mix');
const publicPath = 'public';

const inProduction = mix.inProduction();

/*
 |--------------------------------------------------------------------------
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.setPublicPath(publicPath);

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

mix.sass('resources/sass/app.scss', `${publicPath}/css`)
    .options({
        uglify: {
            parallel: 8,
            uglifyOptions: {
                mangle: true,
                compress: true,
            },
        },
        processCssUrls: false
    })
    .minify(`${publicPath}/css/app.css`)
    .sourceMaps()
    .version();

mix.js('resources/js/app.js', `${publicPath}/js`)
    .minify(`${publicPath}/js/app.js`)
    .sourceMaps()
    .version();


/*
 |--------------------------------------------------------------------------
 | Common
 |
 */
mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts', `${publicPath}/webfonts`);
