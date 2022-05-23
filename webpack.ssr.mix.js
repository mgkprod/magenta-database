const path = require('path');
const mix = require('laravel-mix');
const webpackNodeExternals = require('webpack-node-externals');

mix.alias({
  ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue'),
});

mix
  .options({ manifest: false })
  .js('resources/js/ssr.js', 'public/js')
  .vue({ version: 2, options: { optimizeSSR: true } })
  .alias({ '@': path.resolve('resources/js') })
  .webpackConfig({
    target: 'node',
    externals: [webpackNodeExternals()],
  });
