<template>
  <nuxt-link
    :to="archiveLink || `/projects/${project.slug}`"
    class="project-item-alt aspect-[6/2] grid grid-cols-4 border border-grey-2 rounded-2xl overflow-hidden"
  >
    <div class="col-span-1 h-full relative">
      <figure class="fill-parent">
        <DefImage
          v-if="mainImage"
          :image-data="mainImage"
          class="w-full h-full object-cover"
        />
      </figure>
    </div>

    <div class="col-span-3 text-sm leading-[1.2] py-2 px-3">
      <p class="text-black line-clamp-2">{{ projectTitle }}</p>

      <p
        v-if="projectSectors"
        class="text-grey-3"
      >
        {{ projectSectorsString }}
      </p>
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
  return props.project.projectServiceCategories.nodes
})

const projectSectorsString = computed(() => {
  return props.project.projectServiceCategories.nodes.map((sector) => sector.name).join(', ')
})

const mainImage = computed(() => {
  return props.project.projectData.mainImage.node
})

const archiveLink = computed(() => {
  return props.project.projectData?.archiveLink?.url
})
</script>

<style scoped lang="postcss">
.project-item-alt {
  background-color: white;
  transition: background-color 0.2s;

  &:hover {
    background-color: var(--color-grey-1);
  }
}
</style>
