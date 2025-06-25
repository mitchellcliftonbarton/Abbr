<template>
  <section
    ref="section"
    v-if="ideas"
    id="all-ideas"
    class="global-ideas-list global-module lg:px-8"
  >
    <div
      class="ideas-container bg-grey-1 w-full lg:w-5/6 mx-auto max-w-[900px] rounded-2xl relative flex flex-col justify-between gap-6 overflow-hidden"
    >
      <div class="titles px-6 pt-6 flex-none">
        <div class="flex justify-between items-center border-b border-grey-2 pb-4">
          <h2 class="text-lg text-grey-2 tracking-default leading-none font-medium">Abbr. Ideas</h2>

          <CopyLink :text="linkToCopy" />
        </div>
      </div>

      <div
        ref="ideasContainer"
        class="all-ideas flex-none flex flex-nowrap gap-3 lg:gap-2 px-6 overflow-x-auto"
      >
        <IdeaLink
          v-for="(idea, index) in ideas"
          :key="idea.id"
          :idea="idea"
          :index="index"
          @idea-click="handleIdeaClick"
        />
      </div>

      <div class="flex-1 relative">
        <IdeaContentItem
          v-if="currentIdea"
          :idea="currentIdea"
          :key="currentIdea.id"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import DynamicLink from '~/components/DynamicLink.vue'
import IdeaLink from '~/components/IdeaLink.vue'
import IdeaContentItem from '~/components/IdeaContentItem.vue'
import CopyLink from '~/components/CopyLink.vue'
import { gsap, ScrollTrigger } from 'gsap/all'
gsap.registerPlugin(ScrollTrigger)

// define props
const props = defineProps({
  module: {
    type: Object,
    required: true,
  },
})

// get event bus
const { $event } = useNuxtApp()

// define refs
const section = ref(null)
const scrollTriggerInstance = ref(null)

const route = useRoute()

// define data
const type = computed(() => props.module?.type?.[0])
const featuredIdeas = computed(() => props.module?.featuredIdeas)
const allPosts = useState('allPosts')
const ideasContainer = ref(null)

// computed
const ideas = computed(() => {
  if (type.value === 'all') {
    return allPosts.value
  }

  return featuredIdeas.value
})

const ideaSlug = computed(() => route.query.idea)

const currentIdea = computed(() => {
  if (ideaSlug.value) {
    return allPosts.value.find((idea) => idea.slug === ideaSlug.value)
  }

  return ideas.value[0]
})

const linkToCopy = computed(() => {
  if (process.client) {
    return `${window.location.origin}?idea=${currentIdea.value.slug}`
  }

  return `/?idea=${currentIdea.value.slug}`
})

const handleIdeaClick = () => {
  // scroll section into view
  section.value.scrollIntoView({
    behavior: 'smooth',
  })
}

watch(
  () => route.query.idea,
  () => {
    $event('update-scroll-triggers')
  }
)

// const setScrollPosition = () => {
//   if (ideaSlug.value) {
//     const ideaLinks = Array.from(ideasContainer.value.querySelectorAll('.idea-link'))

//     const link = ideaLinks.find((link) => link.dataset.slug === ideaSlug.value)

//     if (link) {
//       ideasContainer.value.scrollTo({
//         left: link.offsetLeft - 15,
//         behavior: 'smooth',
//       })
//     }
//   }
// }

// watch(ideaSlug, () => {
//   if (ideaSlug.value) {
//     setScrollPosition()
//   }
// })

onMounted(() => {
  // setScrollPosition()

  scrollTriggerInstance.value = ScrollTrigger.create({
    trigger: section.value,
    start: 'top 75%',
    scrub: false,
    once: true,
    animation: gsap.to(section.value, {
      opacity: 1,
      y: 0,
      duration: 0.5,
    }),
  })

  nextTick(() => {
    // check if route has idea param
    const ideaParam = route.query.idea

    if (ideaParam) {
      setTimeout(() => {
        section.value.scrollIntoView({
          behavior: 'smooth',
        })
      }, 300) // dont like this solution but it works
    }
  })
})

onUnmounted(() => {
  if (scrollTriggerInstance.value) {
    scrollTriggerInstance.value.kill()
  }
})
</script>

<style scoped lang="postcss">
.global-ideas-list {
  scroll-margin-top: 130px;
  opacity: 0;
  transform: translateY(20px);

  .all-ideas {
    &::-webkit-scrollbar {
      display: none;
    }

    -ms-overflow-style: none;
    scrollbar-width: none;
  }
}
</style>
