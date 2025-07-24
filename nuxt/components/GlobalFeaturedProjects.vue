<template>
  <section class="global-featured-projects global-module px-4 lg:px-8">
    <div class="titles flex justify-between items-center border-b border-black pb-4">
      <h2
        v-if="headline"
        class="text-lg text-grey-2 tracking-default leading-none font-medium"
      >
        {{ headline }}
      </h2>

      <DynamicLink
        href="/projects"
        class="circle-link"
      >
        <div class="text-content">
          <div>View All</div>
          <div>View All</div>
        </div>
      </DynamicLink>
    </div>

    <div v-if="featuredProjects.length">
      <div class="project-items-container mt-12 hidden lg:block">
        <FeaturedProjectItem
          @mouseenter="handleMouseEnter"
          @mouseleave="handleMouseLeave"
          v-for="(projectItem, index) in featuredProjects"
          :key="projectItem.project.nodes[0].id"
          :project-item="projectItem"
          :index="index"
          :is-odd="index % 2 === 1"
        />
      </div>

      <div class="carousel lg:hidden aspect-[4/4.8] relative rounded-2xl overflow-hidden mt-12">
        <swiper
          :slides-per-view="1"
          :space-between="0"
          :loop="true"
          :grab-cursor="true"
        >
          <swiper-slide
            v-for="(projectItem, index) in featuredProjects"
            :key="projectItem.project.nodes[0].id"
          >
            <DynamicLink
              :href="`/projects/${projectItem.project.nodes[0].slug}`"
              class="flex flex-col bg-grey-1 fill-parent"
            >
              <figure class="w-full aspect-[2/1.5] flex-none">
                <DefImage
                  v-if="projectItem?.image?.node"
                  :image-data="projectItem.image.node"
                  class="w-full h-full object-cover lazyload"
                />
              </figure>

              <div class="flex-1 p-6 flex flex-col justify-between items-start">
                <div
                  v-if="projectItem.text"
                  v-html="projectItem.text"
                  class="text-base text-black font-medium leading-none tracking-default"
                />

                <div class="flex justify-between items-end w-full">
                  <div class="def-button">View Project</div>

                  <div class="dots flex items-center gap-3">
                    <span
                      v-for="(project, i) in featuredProjects"
                      :key="project.project.nodes[0].id"
                      :class="{
                        active: i === index,
                      }"
                    ></span>
                  </div>
                </div>
              </div>
            </DynamicLink>
          </swiper-slide>
        </swiper>
      </div>
    </div>
  </section>
</template>

<script setup>
import DynamicLink from '~/components/DynamicLink.vue'
import FeaturedProjectItem from '~/components/FeaturedProjectItem.vue'
import { gsap, ScrollTrigger } from 'gsap/all'
gsap.registerPlugin(ScrollTrigger)
import { Swiper, SwiperSlide } from 'swiper/vue'
import 'swiper/css'
import DefImage from '~/components/DefImage.vue'

// get event bus
const { $event } = useNuxtApp()

const isLargeQuery = useState('isLargeQuery')

// define props
const props = defineProps({
  module: {
    type: Object,
    required: true,
  },
})

// computed
const featuredProjects = computed(() => props.module?.projects.filter((project) => project.project.nodes.length))
const headline = computed(() => props.module?.headline)

const handleMouseEnter = () => {
  $event('show-custom-cursor')
}

const handleMouseLeave = () => {
  $event('hide-custom-cursor')
}

onMounted(() => {
  // $listen('update-scroll-triggers', () => {
  //   if (scrollTrigger.value) {
  //     scrollTrigger.value.refresh()
  //   }
  // })

  if (isLargeQuery.value) {
    // define scroll trigger
    const globalFeaturedProjects = document.querySelector('.global-featured-projects')
    const titles = document.querySelector('.global-featured-projects .titles')
    const titlesHeight = titles.offsetHeight * 2
    const projectItemsContainer = document.querySelector('.project-items-container')
    const projectItems = Array.from(document.querySelectorAll('.project-item'))
    const projectItemsContainerHeight = projectItemsContainer.offsetHeight

    const tl = gsap.timeline({
      paused: true,
      scrollTrigger: {
        trigger: globalFeaturedProjects,
        start: 'top 65',
        end: `+=${projectItemsContainerHeight * (projectItems.length + 1) + titlesHeight}px`,
        scrub: true,
        pin: true,
      },
    })

    const baseHeight = 15
    const totalInactiveItemsHeight = (projectItems.length - 1) * baseHeight
    const remainderHeight = projectItemsContainerHeight - totalInactiveItemsHeight - titlesHeight

    // first set initial heights
    projectItems.forEach((item, index) => {
      if (index === 0) {
        item.style.height = `${remainderHeight}px`
      } else {
        item.style.height = `${baseHeight}px`
      }
    })

    tl.to(projectItems[0], {
      height: baseHeight,
      duration: 0.5,
      ease: 'linear',
    })

    // then animate
    projectItems.forEach((item, index) => {
      // only animate the items after the first one
      if (index > 0) {
        tl.to(
          item,
          {
            height: remainderHeight,
            duration: 0.5,
            ease: 'linear',
          },
          '-=0.5'
        )

        tl.to(item, {
          height: baseHeight,
          duration: 0.5,
          ease: 'linear',
        })
      }
    })
  }
})
</script>

<style scoped lang="postcss">
.project-items-container {
  height: calc(100svh - 8rem);

  .project-item {
    height: 15px;
  }
}

.carousel {
  .swiper {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    .swiper-slide {
      .dots {
        span {
          width: 10px;
          height: 10px;
          background-color: rgba(0, 0, 0, 0.4);
          border-radius: 50%;

          &.active {
            background-color: black;
          }
        }
      }
    }
  }
}
</style>
