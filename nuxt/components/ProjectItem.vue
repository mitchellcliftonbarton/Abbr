<template>
  <nuxt-link
    :to="`/projects/${project.slug}`"
    class="project-item grid grid-cols-2 gap-8 p-8"
  >
    <figure class="aspect-[4/5] col-span-1 rounded-2xl overflow-hidden bg-grey-1">
      <DefImage
        v-if="mainImage"
        :image-data="mainImage"
        class="w-full h-full object-cover"
      />
    </figure>

    <div class="col-span-1">
      <div>
        <h2 class="text-base text-black tracking-[-.02em] leading-none font-medium">{{ projectTitle }}</h2>

        <p
          v-if="projectSectors"
          class="text-base text-grey-2 tracking-[-.02em] leading-none font-medium"
        >
          {{ projectSectorsString }}
        </p>
      </div>

      <div
        v-if="projectIntroText"
        class="intro-text mt-8 text-base text-black tracking-[-.02em] leading-none font-medium"
        v-html="projectIntroText"
      ></div>
    </div>
  </nuxt-link>
</template>

<script setup>
import DefImage from '~/components/DefImage.vue'

const props = defineProps({
  project: {
    type: Object,
    required: true,
  },
})

// computed
const projectTitle = computed(() => {
  return props.project.title
})

const projectSectors = computed(() => {
  return props.project.projectSectors.nodes
})

const projectSectorsString = computed(() => {
  return props.project.projectSectors.nodes.map((sector) => sector.name).join(', ')
})

const projectIntroText = computed(() => {
  return props.project.projectData.introText
})

const mainImage = computed(() => {
  return props.project.projectData.mainImage.node
})
</script>

<style scoped lang="postcss">
.project-item {
  background-color: transparent;
  transition: background-color 0.2s;

  .intro-text {
    opacity: 0;
    transition: opacity 0.2s;
    pointer-events: none;
  }

  &:hover {
    background-color: var(--color-grey-1);

    .intro-text {
      opacity: 1;
      pointer-events: auto;
    }
  }
}
</style>
