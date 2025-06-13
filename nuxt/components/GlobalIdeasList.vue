<template>
  <section
    v-if="ideas"
    id="all-ideas"
    class="global-ideas-list global-module px-8"
  >
    <div
      class="ideas-container bg-grey-1 w-5/6 mx-auto max-w-[900px] rounded-2xl aspect-[3.5/2.2] relative flex flex-col justify-between gap-6 overflow-hidden"
    >
      <div class="titles px-6 pt-6 flex-none">
        <div class="flex justify-between items-center border-b border-grey-2 pb-4">
          <h2 class="text-lg text-grey-2 tracking-[-.02em] leading-none font-medium">Abbr. Ideas</h2>

          <DynamicLink
            href="/"
            class="circle-link"
            >Share</DynamicLink
          >
        </div>
      </div>

      <div
        ref="ideasContainer"
        class="all-ideas flex-none flex flex-nowrap gap-2 px-6 overflow-x-auto"
      >
        <IdeaLink
          v-for="idea in ideas"
          :key="idea.id"
          :idea="idea"
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

// define props
const props = defineProps({
  module: {
    type: Object,
    required: true,
  },
})

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

const setScrollPosition = () => {
  if (ideaSlug.value) {
    const ideaLinks = Array.from(ideasContainer.value.querySelectorAll('.idea-link'))

    const link = ideaLinks.find((link) => link.dataset.slug === ideaSlug.value)

    if (link) {
      ideasContainer.value.scrollTo({
        left: link.offsetLeft - 15,
        behavior: 'smooth',
      })
    }
  }
}

watch(ideaSlug, () => {
  if (ideaSlug.value) {
    setScrollPosition()
  }
})

onMounted(() => {
  setScrollPosition()
})
</script>

<style scoped lang="postcss">
.global-ideas-list {
  scroll-margin-top: 130px;

  .idea-link {
    background-color: white;
    transition: background-color 0.2s;

    &.active {
      background-color: var(--color-green);
    }
  }

  .all-ideas {
    &::-webkit-scrollbar {
      display: none;
    }

    -ms-overflow-style: none;
    scrollbar-width: none;
  }
}
</style>
