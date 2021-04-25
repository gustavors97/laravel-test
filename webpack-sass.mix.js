const mix = require('laravel-mix');
require('laravel-mix-purgecss');

mix.sass('resources/sass/app.scss', 'public/css/npm/main.css')
   .options({
       processCssUrls: false
   })
   .purgeCss({
        css: ['public/css/npm/*.css'],
		content: [
			'resources/views/**/*.vue',
			'resources/views/**/*.blade.php'
        ],
        fontFace: true,
		keyframes: true,
		variables: true,
		rejected: true
   });