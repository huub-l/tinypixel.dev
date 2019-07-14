const mix = require('laravel-mix')

const publicPath = path => `${mix.config.publicPath}/${path}`
const src = path => `resources/assets/${path}`

mix
  .setPublicPath('./dist')
  .setResourceRoot(`/app/themes/sage/${mix.config.publicPath}/`)
  .webpackConfig({
    output: { publicPath: mix.config.resourceRoot }
  })

mix.browserSync('https://tinypixel.valet')

mix.sass(src`styles/app.scss`, 'styles')

mix.js(src`scripts/app.js`, 'scripts')
    .js(src`scripts/customizer.js`, 'scripts')
    .extract()

mix.copyDirectory(src`images`, publicPath`images`)
    .copyDirectory(src`fonts`, publicPath`fonts`)
    .autoload({ jquery: ['$', 'window.jQuery'] })
    .options({ processCssUrls: false })
