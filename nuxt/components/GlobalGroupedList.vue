<template>
  <section
    ref="section"
    v-if="groups.length"
    class="global-grouped-list global-module relative z-10"
  >
    <div
      v-if="headline || eyebrowLink"
      class="titles flex justify-between items-center border-b border-black pb-4 px-4 lg:px-8"
    >
      <h2
        v-if="headline"
        class="text-lg text-grey-2 tracking-default leading-none font-medium"
      >
        {{ headline }}
      </h2>

      <DynamicLink
        v-if="eyebrowLink"
        :href="eyebrowLink.url"
        class="circle-link"
      >
        {{ eyebrowLink.title }}
      </DynamicLink>
    </div>

    <DynamicLink
      v-for="group in groups"
      :href="group.link.url"
      :key="group.id"
      class="group-item grid grid-cols-12 gap-8 border-b border-black px-8 pt-3 pb-6"
    >
      <div class="group-item-title col-span-8">
        <h3 class="title text-base lg:text-lg text-grey-3 tracking-default leading-none font-medium">
          {{ group.title }}
        </h3>

        <div
          v-html="group.subtitle"
          class="subtitle text-base lg:text-lg text-grey-2 tracking-default leading-none font-medium w-1/2 max-w-[500px]"
        ></div>
      </div>

      <div class="col-span-4 relative">
        <div
          v-html="nl2br(group.text)"
          class="text text-base lg:text-lg text-grey-3 tracking-default leading-none font-medium"
        ></div>

        <div class="def-button absolute top-0 right-0">
          {{ group.link.title }}
        </div>
      </div>
    </DynamicLink>
  </section>
</template>

<script setup>
import DynamicLink from '~/components/DynamicLink.vue'
import { nl2br } from '~/lib/utils'
import { gsap, ScrollTrigger } from 'gsap/all'
gsap.registerPlugin(ScrollTrigger)

// get event bus
const { $listen } = useNuxtApp()

// define props
const props = defineProps({
  module: {
    type: Object,
    required: true,
  },
})

// define data
const headline = computed(() => props.module?.headline)
const eyebrowLink = computed(() => props.module?.eyebrow_link)
const groups = computed(() => props.module?.groups)

// define refs
const section = ref(null)
const scrollTriggerInstance = ref(null)

// define methods
onMounted(() => {
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

  $listen('update-scroll-triggers', () => {
    if (scrollTrigger.value) {
      scrollTrigger.value.refresh()
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
.global-grouped-list {
  opacity: 0;
  transform: translateY(20px);

  .group-item {
    transition: background-color 0.2s;

    .def-button,
    .subtitle {
      opacity: 0;
      transition: opacity 0.2s;
      pointer-events: none;
    }

    .text {
      transition: transform 0.2s;
    }

    &:hover {
      background-color: var(--color-grey-1);

      .def-button,
      .subtitle {
        opacity: 1;
        pointer-events: auto;
      }

      .text {
        transform: translateX(-100px);
      }
    }
  }
}
</style>
