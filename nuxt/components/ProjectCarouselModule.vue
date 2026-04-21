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
        class="rich-text mt-4 leading-[1.1] w-full lg:w-1/2"
        v-html="module.caption"
      ></div>
    </div>

    <div
      ref="containerRef"
      class="carousel-container col-span-12 lg:col-span-6 order-first lg:order-last"
      :class="aspectRatio.class"
    >
      <div
        class="carousel bg-grey-1 rounded-2xl overflow-hidden mx-auto relative"
        :style="{ aspectRatio: aspectRatio.value }"
      >
        <div
          v-if="carouselMedia.length > 1"
          class="timer flex gap-3 absolute top-4 right-4 z-20"
        >
          <button
            v-for="(item, index) in carouselMedia"
            :key="item.id"
            class="carousel-button"
            :class="{ active: index === currentIndex }"
            @click="carousel.slideToLoop(index)"
          >
            <div class="indicator"></div>
          </button>
        </div>

        <swiper
          :slides-per-view="1"
          :space-between="0"
          :loop="true"
          :grab-cursor="true"
          :modules="[Autoplay]"
          :autoplay="{
            delay: slideDuration,
            disableOnInteraction: false,
          }"
          @swiper="onSwiper"
          @slide-change="onSlideChange"
        >
          <swiper-slide
            v-for="(item, index) in carouselMedia"
            :key="item.id"
          >
            <DefImage
              v-if="item.mimeType.includes('image')"
              :image-data="item"
              class="w-full h-full object-cover"
            />

            <video
              v-else-if="item.mimeType.includes('video')"
              :src="item.mediaItemUrl"
              class="w-full h-full object-cover"
              autoplay
              muted
              loop
              playsinline
              preload="auto"
            />
          </swiper-slide>
        </swiper>
      </div>
    </div>
  </section>
</template>

<script setup>
import DefImage from '~/components/DefImage.vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay } from 'swiper/modules'
import 'swiper/css'
import { gsap } from 'gsap/all'

const props = defineProps({
  module: {
    type: Object,
    required: true,
  },
})

const carousel = ref(null)
const containerRef = ref(null)
const currentIndex = ref(0)
const timer = ref(null)
const slideDuration = ref(7000)
const indicatorMinValue = ref(5)
const indicatorMaxValue = ref(30)
const indicatorWidth = ref(indicatorMinValue.value)
const currentAnimation = ref(null)

const carouselMedia = computed(() => {
  return props.module.carouselMedia?.nodes || []
})

const firstCarouselMedia = computed(() => {
  return carouselMedia?.value[0]
})

const aspectRatio = computed(() => {
  if (firstCarouselMedia?.value) {
    const aspectRatio = firstCarouselMedia.value.mediaDetails.width / firstCarouselMedia.value.mediaDetails.height

    return {
      class: aspectRatio > 1 ? 'landscape' : 'portrait',
      value: aspectRatio,
    }
  }

  return false
})

// methods
const onSwiper = (swiper) => {
  carousel.value = swiper
}

const onSlideChange = (swiper) => {
  currentIndex.value = swiper.realIndex

  // set all indicators to min value
  const root = containerRef.value
  const indicators = Array.from(root.querySelectorAll('.carousel-button .indicator'))
  indicators.forEach((indicator) => {
    gsap.set(indicator, { scaleX: 0 })
  })

  nextTick(() => {
    // get current indicator
    const currentIndicator = root.querySelector(`.carousel-button.active .indicator`)

    if (currentIndicator) {
      // Kill any existing animation
      if (currentAnimation.value) {
        currentAnimation.value.kill()
      }

      currentAnimation.value = gsap.fromTo(
        currentIndicator,
        { scaleX: indicatorMinValue.value / indicatorMaxValue.value },
        {
          scaleX: 1,
          duration: slideDuration.value / 1000,
          ease: 'linear',
        },
      )
    }
  })
}

// Cleanup on unmount
onBeforeUnmount(() => {
  if (currentAnimation.value) {
    currentAnimation.value.kill()
  }
})
</script>

<style scoped lang="postcss">
.carousel-container {
  &.portrait {
    .carousel {
      width: 100%;

      @media screen and (min-width: 1024px) {
        width: 70%;
      }
    }
  }

  &.landscape {
    .carousel {
      width: 100%;
    }
  }

  .carousel-button {
    background-color: rgba(255, 255, 255, 0.5);
    width: 10px;
    height: 10px;
    border-radius: 99999px;
    transition: width 0.2s;
    position: relative;
    overflow: hidden;

    .indicator {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: white;
      opacity: 0;
      transition: opacity 0.2s;
      border-radius: 99999px;
      transform: scaleX(0);
      transform-origin: left center;
    }

    &.active {
      width: 30px;

      .indicator {
        opacity: 1;
      }
    }
  }
}
</style>
