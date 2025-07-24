<template>
  <nuxt-link
    :to="archiveLink || `/projects/${project.slug}`"
    target="_blank"
    class="project-item-alt aspect-[6/2] border border-grey-2 rounded-2xl overflow-hidden"
  >
    <div class="inner flex h-full">
      <div class="view">
        <p class="font-secondary uppercase text-xs p-2">View Project</p>
      </div>

      <div class="image h-full relative">
        <figure class="fill-parent">
          <DefImage
            v-if="mainImage"
            :image-data="mainImage"
            class="w-full h-full object-cover"
          />
        </figure>
      </div>

      <div class="titles text-sm leading-[1.2] py-2 px-3">
        <p class="text-black line-clamp-2">{{ projectTitle }}</p>

        <p
          v-if="projectSectors"
          class="text-grey-3"
        >
          {{ projectSectorsString }}
        </p>
      </div>
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

  .view {
    width: 75%;
    flex: none;
    background-color: var(--color-grey-1);

    p {
      display: flex;
      align-items: center;
      gap: 0.5rem;

      &::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--color-green);
        transform: translateY(0.08em);
      }
    }
  }

  .image {
    width: 25%;
    flex: none;
  }

  .titles {
    width: 75%;
    flex: none;
    transition: background-color 0.2s;
  }

  .inner {
    transition: transform 0.2s;
    transform: translateX(-75%);
  }

  @media screen and (min-width: 1024px) {
    &:hover {
      .inner {
        transform: translateX(0%);
      }
    }
  }
}
</style>
