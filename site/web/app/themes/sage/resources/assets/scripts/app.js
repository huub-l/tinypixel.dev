import 'jquery'

import Router from './util/Router'
import common from './routes/common'
import home from './routes/home'
import aboutUs from './routes/about'

const routes = new Router({
  common,
  home,
  aboutUs,
})

jQuery(document).ready(() => routes.loadEvents())
