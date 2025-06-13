import 'lazysizes'
// import Swup from 'swup'
import MiniCarousel from './classes/MiniCarousel'
import IdeasContainer from './classes/IdeasContainer'

document.addEventListener('DOMContentLoaded', () => {
  /*
  ----------------
  CREDITS
  ----------------
  */

  console.log('%c \nDevelopment by Cold Rice \n \ncold-rice.info \n \n', 'color: grey')

  /*
  ----------------
  VARS
  ----------------
  */

  let isLargeQuery = window.matchMedia('(min-width: 1024px)').matches

  // define custom elements
  customElements.define('mini-carousel', MiniCarousel)
  customElements.define('ideas-container', IdeasContainer)

  /*
  ----------------
  SWUP
  ----------------
  */

  // const swup = new Swup()
})
