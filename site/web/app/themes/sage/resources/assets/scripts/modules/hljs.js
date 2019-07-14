import hljs from 'highlight.js/lib/highlight'
import javascript from 'highlight.js/lib/languages/javascript'
import php from 'highlight.js/lib/languages/php'
import bash from 'highlight.js/lib/languages/bash'
import 'highlight.js/styles/dracula.css'

hljs.registerLanguage('javascript', javascript)
hljs.registerLanguage('php', php)
hljs.registerLanguage('bash', bash)

const syntaxHighlight = window.onload = () => {
  document.querySelectorAll('pre.wp-block-code code, pre.wp-block-preformatted').forEach(block =>
    hljs.highlightBlock(block)
  )
}

export default syntaxHighlight
