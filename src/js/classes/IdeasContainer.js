export default class IdeasContainer extends HTMLElement {
  constructor() {
    super()

    this.ideaLinksContainer = this.querySelector('.all-ideas')
    this.ideaLinks = Array.from(this.querySelectorAll('.idea-link'))
    this.ideaContentItems = Array.from(this.querySelectorAll('.idea-content-item'))
  }

  connectedCallback() {
    this.ideaLinks.forEach((link) => {
      link.addEventListener('click', (e) => {
        e.preventDefault()

        this.openLink({ link })

        // get href
        const href = link.href

        // push state
        history.pushState({}, '', href)
      })
    })

    window.addEventListener('popstate', (e) => {
      e.preventDefault()

      const href = window.location.href

      this.openLink({ href })
    })
  }

  openLink({ link = null, href = null }) {
    let linkEl = link || this.ideaLinks.find((link) => link.href === href)

    if (linkEl === undefined) {
      linkEl = this.ideaLinks[0]
    }

    this.ideaLinks.forEach((link) => {
      link.classList.remove('active')
    })

    linkEl.classList.add('active')

    // scroll to the x coordinate of the link inside of the links container
    this.ideaLinksContainer.scrollTo({
      left: linkEl.offsetLeft - 15,
      behavior: 'smooth',
    })

    this.ideaContentItems.forEach((item) => {
      item.classList.remove('active')
    })

    this.ideaContentItems[this.ideaLinks.indexOf(linkEl)].classList.add('active')
  }
}
