
import fontAwesome from '../modules/font-awesome'
import doLegacy from '../modules/legacy'
import syntaxHighlight from '../modules/hljs'

export default {
  init() {
    fontAwesome(),
    doLegacy(),
    syntaxHighlight()
  },
  finalize() {
  },
}
