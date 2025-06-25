<template>
  <section class="grid grid-cols-12 gap-8 px-4 lg:px-8">
    <div class="col-span-12 lg:col-span-6 order-last lg:order-first">
      <h2
        v-if="module.title"
        class="uppercase text-sm font-medium"
      >
        {{ module.title }}
      </h2>

      <div
        v-if="module.caption"
        class="rich-text mt-4 font-medium leading-none w-1/2"
        v-html="module.caption"
      ></div>
    </div>

    <div
      class="image col-span-12 lg:col-span-6 order-first lg:order-last"
      :class="aspectRatio.class"
    >
      <figure
        v-if="module?.image?.node || module?.video?.node"
        class="w-full rounded-2xl overflow-hidden bg-grey-1 mx-auto"
        :style="{ aspectRatio: aspectRatio.value }"
      >
        <video
          v-if="isVideo"
          :src="module.video.node.mediaItemUrl"
          class="w-full h-full object-cover"
          autoplay
          muted
          loop
          playsinline
          preload
        />

        <DefImage
          v-else-if="module?.image?.node"
          :image-data="module.image.node"
          class="w-full h-full object-cover"
        />
      </figure>
    </div>
  </section>
</template>

<script setup>
const props = defineProps({
  module: {
    type: Object,
    required: true,
  },
})

const isVideo = computed(() => {
  return props.module?.video?.node
})

const aspectRatio = computed(() => {
  let width = null
  let height = null

  if (isVideo.value) {
    width = props.module?.video?.node?.mediaDetails?.width
    height = props.module?.video?.node?.mediaDetails?.height
  } else if (props.module?.image?.node) {
    width = props.module?.image?.node?.mediaDetails?.width
    height = props.module?.image?.node?.mediaDetails?.height
  }

  const aspectRatio = width / height

  if (height > width) {
    return {
      class: 'portrait',
      value: aspectRatio,
    }
  }

  return {
    class: 'landscape',
    value: aspectRatio,
  }
})
</script>

<style scoped lang="postcss">
.image {
  &.portrait {
    figure {
      width: 100%;

      @media screen and (min-width: 1024px) {
        width: 70%;
      }
    }
  }

  &.landscape {
    figure {
      width: 100%;
    }
  }
}
</style>
