<template>
  <section
    v-if="backgroundImage && carouselItems.length"
    class="global-mini-carousel global-module h-[100svh] w-full lg:max-h-[900px] min-h-[500px] relative bg-grey-1 flex justify-center items-center"
  >
    <figure class="fill-parent">
      <DefImage
        :image-data="backgroundImage"
        class="object-cover w-full h-full object-center lazyload"
      />
    </figure>

    <div
      class="carousel-wrapper block w-5/6 lg:w-1/4 max-w-[400px] aspect-[4/5.8] relative rounded-xl flex flex-col justify-between"
    >
      <div class="flex justify-between items-center flex-none p-6">
        <h2
          v-if="carouselTitle"
          class="text-sm uppercase text-grey-2 tracking-default leading-none font-medium"
        >
          {{ carouselTitle }}
        </h2>

        <div
          v-if="carouselItems.length > 1"
          class="flex gap-3"
        >
          <button
            v-for="(item, index) in carouselItems"
            :key="item.id"
            class="carousel-button"
            :class="{ active: index === currentIndex }"
            @click="carousel.slideToLoop(index)"
          >
            <div class="indicator"></div>
          </button>
        </div>
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
          v-for="(item, index) in carouselItems"
          :key="item.id"
          class="fill-parent pt-4 px-6"
        >
          <div class="quote text-lg tracking-default leading-none font-medium">
            <p>“</p>
            <div v-html="item.quote"></div>
          </div>

          <div class="mt-6 flex flex-col items-start gap-1">
            <div
              v-if="item.author"
              class="author text-sm tracking-default leading-none font-medium py-[.1em]"
            >
              {{ item.author }}
            </div>

            <div
              v-if="item.source"
              class="source text-sm tracking-default leading-none font-medium opacity-50 py-[.1em]"
            >
              {{ item.source }}
            </div>
          </div>
        </swiper-slide>
      </swiper>

      <div class="p-6 flex-none">
        <CopyLink
          v-if="carouselLink && carouselLink.url.includes('mailto:')"
          :text="carouselLink.title"
          :text-to-copy="carouselLink.url"
          type="circle-white"
        />
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
import CopyLink from '~/components/CopyLink.vue'

// define props
const props = defineProps({
  module: {
    type: Object,
    required: true,
  },
})

const carousel = ref(null)
const currentIndex = ref(0)
const timer = ref(null)
const slideDuration = ref(7000)
const indicatorMinValue = ref(5)
const indicatorMaxValue = ref(30)
const indicatorWidth = ref(indicatorMinValue.value)
const currentAnimation = ref(null)

// define data
const backgroundImage = computed(() => props.module?.backgroundImage?.node)
const carouselTitle = computed(() => props.module?.carouselTitle)
const carouselLink = computed(() => props.module?.carouselLink)
const carouselItems = computed(() => props.module?.carouselItems.filter((item) => item.quote))

// methods
const onSwiper = (swiper) => {
  carousel.value = swiper
}

const onSlideChange = (swiper) => {
  currentIndex.value = swiper.realIndex

  // set all indicators to min value
  const indicators = Array.from(document.querySelectorAll('.carousel-button .indicator'))
  indicators.forEach((indicator) => {
    gsap.set(indicator, { scaleX: 0 })
  })

  nextTick(() => {
    // get current indicator
    const currentIndicator = document.querySelector(`.carousel-button.active .indicator`)

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
.global-mini-carousel {
  .carousel-wrapper {
    background-color: rgba(255, 255, 255, 0.2);
    z-index: 50;
    backdrop-filter: blur(15px);
    color: white;
    min-width: 400px;

    * {
      color: white;
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

    .swiper {
      width: 100%;
    }

    /* .swiper-wrapper {
      position: abso
    } */
  }
}
</style>
