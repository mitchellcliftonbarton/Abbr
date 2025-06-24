<template>
  <footer
    ref="footer"
    id="main-footer"
    class="p-8"
    :class="{ visible: visible }"
  >
    <div class="inner p-6 rounded-2xl flex flex-col justify-between items-center">
      <div class="inner-item flex justify-between items-start w-full pb-[178px]">
        <div
          v-if="footerTextLarge"
          class="text-white text-xl tracking-[-.01em] leading-[.9] font-medium translate-y-[-.12em]"
          v-html="nl2br(footerTextLarge)"
        ></div>

        <nuxt-link to="/">
          <Logo />
        </nuxt-link>
      </div>

      <div
        v-if="footerTextSub || footerLinks"
        class="inner-item flex justify-between items-end w-full"
      >
        <div
          v-if="footerTextSub"
          v-html="footerTextSub"
          class="text-white text-xs rich-text tracking-default leading-[1] max-w-[350px]"
        ></div>

        <div
          v-if="footerLinks"
          class="links flex gap-8"
        >
          <DynamicLink
            v-for="link in footerLinks"
            :key="link.link.url"
            :href="link.link.url"
            class="play-link text-white text-xs font-secondary uppercase"
          >
            <Play />
            <div class="text-content">
              <div>{{ link.link.title }}</div>
              <div>{{ link.link.title }}</div>
            </div>
          </DynamicLink>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import Logo from '~/components/Logo.vue'
import Play from '~/components/Play.vue'
import DynamicLink from '~/components/DynamicLink.vue'
import { nl2br } from '~/lib/utils'
import { gsap, ScrollTrigger } from 'gsap/all'
gsap.registerPlugin(ScrollTrigger)

const footerData = useState('footerData')
const visible = ref(false)
const route = useRoute()

// get event bus
const { $listen } = useNuxtApp()

// computed
const footerTextLarge = computed(() => {
  return footerData.value?.footerTextLarge
})

const footerTextSub = computed(() => {
  return footerData.value?.footerTextSub
})

const footerLinks = computed(() => {
  return footerData.value?.footerLinks
})

// define refs
const footer = ref(null)
const scrollTrigger = ref(null)

// define methods
onMounted(() => {
  scrollTrigger.value = ScrollTrigger.create({
    trigger: footer.value,
    start: 'top 85%',
    scrub: false,
    onEnter: () => {
      visible.value = true
    },
  })

  $listen('update-scroll-triggers', () => {
    if (scrollTrigger.value) {
      scrollTrigger.value.refresh()
    }
  })
})

watch(route, () => {
  if (scrollTrigger.value) {
    visible.value = false

    nextTick(() => {
      scrollTrigger.value.refresh()
    })
  }
})
</script>

<style scoped lang="postcss">
#main-footer {
  color: white;

  .inner {
    background-color: black;

    .inner-item {
      opacity: 0;
      transform: translateY(10px);
      transition:
        opacity 2s var(--curve),
        transform 2s var(--curve);
    }
  }

  .logo-icon {
    width: 9rem;
  }

  &.visible {
    .inner .inner-item {
      opacity: 1;
      transform: translateY(0);
    }
  }
}
</style>
