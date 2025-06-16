<template>
  <DynamicLink
    :href="`/projects/${props.projectItem.project.nodes[0].slug}`"
    class="project-item relative bg-grey-1 rounded-2xl overflow-hidden block"
  >
    <div class="fill-parent grid grid-cols-2">
      <div
        class="col-span-1 bg-grey-4"
        :class="{ 'order-2': isOdd }"
      >
        <DefImage
          v-if="projectItem?.image?.node"
          :image-data="projectItem.image.node"
          class="w-full h-full object-cover lazyload"
        />
      </div>

      <div
        class="col-span-1 p-8"
        :class="{ 'order-1': isOdd }"
      >
        <div
          v-if="projectItem.text"
          v-html="projectItem.text"
          class="text-lg text-black font-medium leading-none tracking-[-.02em]"
        />
      </div>
    </div>
  </DynamicLink>
</template>

<script setup>
import DynamicLink from '~/components/DynamicLink.vue'
import DefImage from '~/components/DefImage.vue'

// define props
const props = defineProps({
  projectItem: {
    type: Object,
    required: true,
  },
  isOdd: {
    type: Boolean,
    required: true,
  },
})
</script>
