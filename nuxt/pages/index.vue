<template>
  <div class="page-modules">
    <component
      :is="getModuleType(module.fieldGroupName)"
      v-for="(module, index) in modules"
      :key="index"
      :module="module"
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

const { data } = await useAsyncData('pageData', () => getPageData({ runTimeConfig, url: '/' }))

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
  }
}
</script>
