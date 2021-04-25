const mix = require('laravel-mix');
const webpack = require('webpack');

mix.js('resources/js/app.js', 'public/js/npm/main.js')
   .js('resources/js/appVue.js', 'public/js/npm/components.js')
   .options({
       postCss: [
           require('autoprefixer'),
       ]
   })
   .webpackConfig({
        output: {
            filename: '[name].js',
            chunkFilename: 'js/npm/[name].js' + (mix.inProduction() ? '?id=[chunkhash]' : ''),
            publicPath: '/'
        }
    });

if (mix.inProduction()) {
    mix.webpackConfig({
        plugins: [
            new webpack.DefinePlugin({
                'process.env.NODE_ENV': JSON.stringify('production')
            }),
            new webpack.optimize.ModuleConcatenationPlugin()
        ],
    })
    .version();
}