let mix = require('laravel-mix')

mix.setPublicPath('./');
mix.js('resources/js/tool.js', 'dist/js');
mix.sass('resources/sass/tool.scss', 'dist/css');
