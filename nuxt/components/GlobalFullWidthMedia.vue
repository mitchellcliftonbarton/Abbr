<template>
  <section
    v-if="hasImage || hasVideo"
    class="global-full-width-media global-module aspect-[9/16] lg:aspect-auto h-auto lg:h-[100svh] w-full bg-grey-1 relative"
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
        class="object-cover w-full h-full object-center transition-opacity duration-1000"
        :class="{
          'hidden lg:block': videoMp4Mobile,
          'opacity-0': !desktopVideoLoaded,
          'opacity-100': desktopVideoLoaded,
        }"
        @canplay="desktopVideoLoaded = true"
        @loadedmetadata="desktopVideoLoaded = true"
        @loadeddata="desktopVideoLoaded = true"
      />

      <video
        v-if="videoMp4Mobile"
        :src="videoMp4Mobile.mediaItemUrl"
        autoplay
        muted
        loop
        playsinline
        class="object-cover w-full h-full object-center transition-opacity duration-1000 block lg:hidden"
        :class="{
          'opacity-0': !mobileVideoLoaded,
          'opacity-100': mobileVideoLoaded,
        }"
        @canplay="mobileVideoLoaded = true"
        @loadedmetadata="mobileVideoLoaded = true"
        @loadeddata="mobileVideoLoaded = true"
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

// video loading states
const desktopVideoLoaded = ref(false)
const mobileVideoLoaded = ref(false)

// qualifiers
const hasImage = computed(() => type.value === 'image' && image.value)
const hasVideo = computed(() => type.value === 'video' && videoMp4.value)

// Reset loading states when video sources change
watch([videoMp4, videoMp4Mobile], () => {
  desktopVideoLoaded.value = false
  mobileVideoLoaded.value = false

  // Fallback timeout to ensure fade-in happens
  setTimeout(() => {
    if (videoMp4.value) desktopVideoLoaded.value = true
    if (videoMp4Mobile.value) mobileVideoLoaded.value = true
  }, 500)
})

// Ensure fade-in on mount
onMounted(() => {
  if (hasVideo.value) {
    setTimeout(() => {
      if (videoMp4.value) desktopVideoLoaded.value = true
      if (videoMp4Mobile.value) mobileVideoLoaded.value = true
    }, 100)
  }
})
</script>
