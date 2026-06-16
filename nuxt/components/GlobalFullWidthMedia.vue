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
          :priority="priority"
          class="object-cover w-full h-full object-center"
        />
      </figure>

      <figure
        v-if="imageMobile"
        class="fill-parent block lg:hidden"
      >
        <DefImage
          :image-data="imageMobile"
          class="object-cover w-full h-full object-center"
        />
      </figure>
    </template>

    <div
      v-else-if="hasVideo"
      class="fill-parent"
    >
      <video
        v-if="!useMobileVideo"
        v-video-in-view
        :src="videoMp4.mediaItemUrl"
        muted
        loop
        playsinline
        preload="none"
        class="object-cover w-full h-full object-center transition-opacity duration-1000"
        :class="{
          'opacity-0': !desktopVideoLoaded,
          'opacity-100': desktopVideoLoaded,
        }"
        @canplay="desktopVideoLoaded = true"
        @loadedmetadata="desktopVideoLoaded = true"
        @loadeddata="desktopVideoLoaded = true"
      />

      <video
        v-else
        v-video-in-view
        :src="videoMp4Mobile.mediaItemUrl"
        muted
        loop
        playsinline
        preload="none"
        class="object-cover w-full h-full object-center transition-opacity duration-1000"
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
  // above-the-fold (first module) loads its image eagerly
  priority: {
    type: Boolean,
    default: false,
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

// viewport tracking so only one video is ever mounted/downloaded.
// defaults to desktop on the server to avoid a hydration flash.
const isMobile = ref(false)
const useMobileVideo = computed(() => isMobile.value && !!videoMp4Mobile.value)

let mql = null
const updateIsMobile = (e) => {
  isMobile.value = e.matches
}

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

// Ensure fade-in on mount + track viewport for single-video rendering
onMounted(() => {
  mql = window.matchMedia('(max-width: 1023px)')
  isMobile.value = mql.matches
  mql.addEventListener('change', updateIsMobile)

  if (hasVideo.value) {
    setTimeout(() => {
      if (videoMp4.value) desktopVideoLoaded.value = true
      if (videoMp4Mobile.value) mobileVideoLoaded.value = true
    }, 100)
  }
})

onBeforeUnmount(() => {
  if (mql) mql.removeEventListener('change', updateIsMobile)
})
</script>
