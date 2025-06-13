import Swiper from 'swiper'
import 'swiper/swiper-bundle.css'

export default class MiniCarousel extends HTMLElement {
  constructor() {
    super()

    this.swiperEl = this.querySelector('.swiper')
    this.carouselButtons = Array.from(this.querySelectorAll('.carousel-button'))
  }

  connectedCallback() {
    if (this.swiperEl) {
      this.swiper = new Swiper(this.swiperEl, {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        grabCursor: true,
      })

      if (this.carouselButtons) {
        this.carouselButtons.forEach((button, index) => {
          button.addEventListener('click', (e) => {
            e.preventDefault()
            this.swiper.slideToLoop(index)
          })
        })
      }

      this.swiper.on('slideChange', () => {
        this.carouselButtons.forEach((button, index) => {
          button.classList.toggle('active', index === this.swiper.realIndex)
        })
      })
    }
  }
}
