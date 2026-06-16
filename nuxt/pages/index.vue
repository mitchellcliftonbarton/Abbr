<template>
  <div class="page-modules">
    <component
      :is="getModuleType(module.fieldGroupName)"
      v-for="(module, index) in modules"
      :key="index"
      :module="module"
      :priority="index === 0"
    />
  </div>
</template>

<script setup>
import { getPageData } from '~/queries/home'

const runTimeConfig = useRuntimeConfig()

// register components
import GlobalIdeasList from '~/components/GlobalIdeasList.vue'
import GlobalMiniCarousel from '~/components/GlobalMiniCarousel.vue'
import GlobalGroupedList from '~/components/GlobalGroupedList.vue'
import GlobalFeaturedProjects from '~/components/GlobalFeaturedProjects.vue'
import GlobalTextImage from '~/components/GlobalTextImage.vue'
import GlobalFullWidthMedia from '~/components/GlobalFullWidthMedia.vue'
import GlobalLogoTicker from '~/components/GlobalLogoTicker.vue'

const nuxtApp = useNuxtApp()
const CACHE_TTL = 1000 * 60 * 30 // 30 min

const { data } = await useAsyncData(
  'pageData',
  async () => {
    const result = await getPageData({ runTimeConfig, url: '/' })
    return result ? { ...result, _fetchedAt: Date.now() } : result
  },
  {
    getCachedData(key) {
      const cached = nuxtApp.payload.data[key] ?? nuxtApp.static?.data?.[key]
      if (!cached?._fetchedAt) return undefined
      if (Date.now() - cached._fetchedAt > CACHE_TTL) return undefined
      return cached
    },
  },
)

const pageTitle = computed(() => data.value?.page?.title)
const modules = computed(() => data.value?.page?.home?.modules)

const getModuleType = (type) => {
  switch (type) {
    case 'HomeModulesIdeasListLayout':
      return GlobalIdeasList
    case 'HomeModulesMiniCarouselLayout':
      return GlobalMiniCarousel
    case 'HomeModulesGroupedListLayout':
      return GlobalGroupedList
    case 'HomeModulesFeaturedProjectsLayout':
      return GlobalFeaturedProjects
    case 'HomeModulesTextImageLayout':
      return GlobalTextImage
    case 'HomeModulesFullWidthMediaLayout':
      return GlobalFullWidthMedia
    case 'HomeModulesLogoTickerLayout':
      return GlobalLogoTicker
  }
}

// Metadata
useMeta({
  title: 'Home',
})
</script>
