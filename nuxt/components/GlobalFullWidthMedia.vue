<template>
  <section
    v-if="hasImage || hasVideo"
    class="global-full-width-media global-module h-[85svh] lg:h-[100svh] w-full bg-grey-1 relative"
  >
    <template v-if="hasImage">
      <figure
        class="fill-parent"
        :class="{ 'hidden lg:block': imageMobile }"
      >
        <DefImage
          :image-data="image"
          class="object-cover w-full h-full object-center lazyload"
        />
      </figure>

      <figure
        v-if="imageMobile"
        class="fill-parent block lg:hidden"
      >
        <DefImage
          :image-data="imageMobile"
          class="object-cover w-full h-full object-center lazyload"
        />
      </figure>
    </template>

    <div
      v-else-if="hasVideo"
      class="fill-parent"
    >
      <video
        :src="videoMp4.mediaItemUrl"
        autoplay
        muted
        loop
        playsinline
        class="object-cover w-full h-full object-center"
        :class="{ 'hidden lg:block': videoMp4Mobile }"
      />

      <video
        v-if="videoMp4Mobile"
        :src="videoMp4Mobile.mediaItemUrl"
        autoplay
        muted
        loop
        playsinline
        class="object-cover w-full h-full object-center block lg:hidden"
      />
    </div>
  </section>
</template>

<script setup>
import DefImage from '~/components/DefImage.vue'

// define props
const props = defineProps({
  module: {
    type: Object,
    required: true,
  },
})

// define data
const type = computed(() => props.module?.type?.[0])
const image = computed(() => props.module?.image?.node)
const videoMp4 = computed(() => props.module?.videoMp4?.node)
const imageMobile = computed(() => props.module?.imageMobile?.node)
const videoMp4Mobile = computed(() => props.module?.videoMp4Mobile?.node)

// qualifiers
const hasImage = computed(() => type.value === 'image' && image.value)
const hasVideo = computed(() => type.value === 'video' && videoMp4.value)
</script>
