// Registers a `v-video-in-view` directive that defers video loading/playback
// until the element is near the viewport. Replaces `autoplay` + eager preload:
// nothing downloads until the video is about to be seen, and it pauses when
// scrolled away. Client-only (relies on IntersectionObserver).

export default defineNuxtPlugin((nuxtApp) => {
  const observers = new WeakMap()

  const play = (el) => {
    const p = el.play()
    if (p && typeof p.catch === 'function') {
      // ignore autoplay rejections (e.g. not yet interactable)
      p.catch(() => {})
    }
  }

  const initFade = (el) => {
    // skip if the component already manages its own opacity (e.g. GlobalFullWidthMedia)
    if (el.classList.contains('opacity-0') || el.classList.contains('opacity-100')) return
    el.style.opacity = '0'
    el.style.transition = 'opacity 1s'
    el.addEventListener('canplay', () => { el.style.opacity = '1' }, { once: true })
  }

  nuxtApp.vueApp.directive('video-in-view', {
    mounted(el) {
      // ensure muted/inline so programmatic play() is allowed to autoplay
      el.muted = true
      el.setAttribute('muted', '')
      el.playsInline = true
      el.preload = 'none'

      // fade in when the video is ready to play
      initFade(el)

      // no IntersectionObserver support → just play
      if (typeof IntersectionObserver === 'undefined') {
        play(el)
        return
      }

      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              play(el)
            } else {
              el.pause()
            }
          })
        },
        { rootMargin: '200px' },
      )

      observer.observe(el)
      observers.set(el, observer)
    },

    unmounted(el) {
      const observer = observers.get(el)
      if (observer) {
        observer.disconnect()
        observers.delete(el)
      }
    },
  })
})
