<template>
  <section class="global-featured-projects global-module px-8">
    <div class="titles flex justify-between items-center border-b border-black pb-4">
      <h2
        v-if="headline"
        class="text-lg text-grey-2 tracking-[-.02em] leading-none font-medium"
      >
        {{ headline }}
      </h2>

      <DynamicLink
        href="/projects"
        class="circle-link"
      >
        View All
      </DynamicLink>
    </div>

    <div class="project-items-container mt-12">
      <FeaturedProjectItem
        v-for="(projectItem, index) in featuredProjects"
        :key="projectItem.project.nodes[0].id"
        :project-item="projectItem"
        :index="index"
        :is-odd="index % 2 === 1"
      />
    </div>
  </section>
</template>

<script setup>
import DynamicLink from '~/components/DynamicLink.vue'
import FeaturedProjectItem from '~/components/FeaturedProjectItem.vue'
import { gsap, ScrollTrigger } from 'gsap/all'
gsap.registerPlugin(ScrollTrigger)

// define props
const props = defineProps({
  module: {
    type: Object,
    required: true,
  },
})

// computed
const featuredProjects = computed(() => props.module?.projects.filter((project) => project.project.nodes.length))
const headline = computed(() => props.module?.headline)

onMounted(() => {
  const projectItemsContainer = document.querySelector('.project-items-container')
  const projectItems = Array.from(document.querySelectorAll('.project-item'))
  const projectItemsContainerHeight = projectItemsContainer.offsetHeight
  const tl = gsap.timeline({
    paused: true,
    scrollTrigger: {
      trigger: projectItemsContainer,
      start: 'top 52',
      end: `+=${projectItemsContainerHeight * (projectItems.length + 1)}px`,
      scrub: true,
      pin: true,
    },
  })
  const baseHeight = 15
  const totalInactiveItemsHeight = (projectItems.length - 1) * baseHeight
  const remainderHeight = projectItemsContainerHeight - totalInactiveItemsHeight

  // first set initial heights
  projectItems.forEach((item, index) => {
    if (index === 0) {
      item.style.height = `${remainderHeight}px`
    } else {
      item.style.height = `${baseHeight}px`
    }
  })

  tl.to(projectItems[0], {
    height: baseHeight,
    duration: 0.5,
    ease: 'linear',
  })

  // then animate
  projectItems.forEach((item, index) => {
    // only animate the items after the first one
    if (index > 0) {
      tl.to(
        item,
        {
          height: remainderHeight,
          duration: 0.5,
          ease: 'linear',
        },
        '-=0.5'
      )

      tl.to(item, {
        height: baseHeight,
        duration: 0.5,
        ease: 'linear',
      })
    }
  })
})
</script>

<style scoped lang="postcss">
.project-items-container {
  height: calc(100svh - 8rem);

  .project-item {
    height: 15px;
  }
}
</style>
