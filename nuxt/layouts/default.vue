<template>
  <div id="root">
    <MainNav />

    <main>
      <slot />
    </main>

    <MainFooter />
  </div>
</template>

<script setup>
import { getGlobalData } from '~/queries/global'
import MainNav from '~/components/MainNav.vue'
import MainFooter from '~/components/MainFooter.vue'

// get runtime config and event bus
const runTimeConfig = useRuntimeConfig()

// fetch global data
const { data, error } = await useAsyncData('global', () => getGlobalData({ runTimeConfig }))

// destructure data
const { projectServiceCategories } = data?.value || []
const { footerTextSub, footerTextLarge, footerLinks } = data?.value?.global?.globalData || {}
const { posts } = data?.value || {}

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
</script>

<style scoped lang="postcss"></style>
