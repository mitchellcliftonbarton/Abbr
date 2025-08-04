<template>
  <div id="root">
    <MainNav />

    <MobileMenu />

    <main>
      <slot />
    </main>

    <MainFooter />

    <div
      class="custom-cursor"
      :class="{ active: showCustomCursor }"
      :style="{ transform: `translate(${customCursorX - 60}px, ${customCursorY - 35}px)` }"
    >
      <p class="def-button">View Project</p>
    </div>
  </div>
</template>

<script setup>
import { getGlobalData } from '~/queries/global'
import MainNav from '~/components/MainNav.vue'
import MainFooter from '~/components/MainFooter.vue'
import MobileMenu from '~/components/MobileMenu.vue'

// get runtime config and event bus
const runTimeConfig = useRuntimeConfig()

// get event bus
const { $listen } = useNuxtApp()

// fetch global data
const { data, error } = await useAsyncData('global', () => getGlobalData({ runTimeConfig }))

// destructure data
const { projectServiceCategories } = data?.value || []
const { footerTextSub, footerTextLarge, footerLinks } = data?.value?.global?.globalData || {}
const { posts } = data?.value || {}

const isLargeQuery = useState('isLargeQuery', () => false)

// computed
const serviceCategories = useState('serviceCategories', () => {
  if (projectServiceCategories?.nodes?.length > 0) {
    return projectServiceCategories.nodes
  }

  return false
})

const footerData = useState('footerData', () => {
  return {
    footerTextSub,
    footerTextLarge,
    footerLinks,
  }
})

const allPosts = useState('allPosts', () => {
  if (posts?.nodes?.length > 0) {
    return posts.nodes
  }

  return false
})

// set default meta data global state
const defaultMeta = useState('defaultMeta', () => {
  return {
    title: 'Abbr. Projects',
    description: data?.value?.global?.globalData?.metaDescription ?? null,
    ogImage: data?.value?.global?.globalData?.ogImage?.node?.mediaItemUrl ?? null,
    ogType: 'website',
  }
})

const mobileMenuOpen = useState('mobileMenuOpen', () => false)

// custom cursor global state
const showCustomCursor = useState('showCustomCursor', () => false)
const customCursorX = useState('customCursorX', () => 0)
const customCursorY = useState('customCursorY', () => 0)

// listen for show close cursor event
$listen('show-custom-cursor', () => {
  showCustomCursor.value = true
})

// listen for hide close cursor event
$listen('hide-custom-cursor', () => {
  showCustomCursor.value = false
})

onMounted(() => {
  // check if the user is on a mobile device
  isLargeQuery.value = window.matchMedia('(min-width: 1024px)').matches

  // listen for mousemove event
  if (isLargeQuery.value) {
    window.addEventListener('mousemove', (event) => {
      customCursorX.value = event.clientX
      customCursorY.value = event.clientY
    })
  }
})
</script>

<style scoped lang="postcss">
.custom-cursor {
  position: fixed;
  top: 0;
  left: 0;
  transition:
    opacity 0.3s,
    transform 0.08s;
  opacity: 0;
  pointer-events: none;

  &.active {
    opacity: 1;
  }
}
</style>
