
import fontAwesome from '../modules/font-awesome'
import doLegacy from '../modules/legacy'
import syntaxHighlight from '../modules/hljs'
import hoverFlair from 'hoverflair.js'

export default {
  init() {
    fontAwesome(),
    doLegacy(),
    syntaxHighlight()

    const target = {
      links: document.querySelectorAll('a:not([class="wp-block-button__link"])'),
      buttons: document.querySelectorAll('a.wp-block-button__link'),
    }

    const options = {
      colors: [
        '#00f',
        '#ffe716',
        '#f92672',
      ],
      transitionClass: `fadeTransition`,
    }

    hoverFlair
      .init(options)
      .addFlair(target.links, 'color')
      .addFlair(target.buttons, 'backgroundColor')
  },
  finalize() {
  },
}
