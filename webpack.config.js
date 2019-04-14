let Encore = require('@symfony/webpack-encore');
// let glob = require("glob");

Encore
    .enableSingleRuntimeChunk()
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .addEntry('js/sport', './assets/js/sport.js')
    // uncomment to define the assets of the project
    .addStyleEntry('css/sport', './assets/css/sport.scss')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();