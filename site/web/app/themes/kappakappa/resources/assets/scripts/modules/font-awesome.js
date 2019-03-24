// base package
import { library, dom } from '@fortawesome/fontawesome-svg-core'

import {
  faFacebook,
  faTwitter,
  faGithub,
  faInstagram,
  faCodepen,
  faCreativeCommons,
  faWordpressSimple,
  faWordpress,
  faAccessibleIcon,
  faDigitalOcean,
  faReact,
  faSass,
  faPhp,
  faStripe,
} from '@fortawesome/free-brands-svg-icons'

const fontAwesome = () => {
  library.add(
    faFacebook,
    faTwitter,
    faGithub,
    faInstagram,
    faCodepen,
    faCreativeCommons,
    faWordpressSimple,
    faWordpress,
    faAccessibleIcon,
    faDigitalOcean,
    faReact,
    faSass,
    faPhp,
    faStripe
  )

  dom.watch()
}

export default fontAwesome