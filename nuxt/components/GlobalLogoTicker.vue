<template>
  <section
    v-if="logos.length"
    class="global-logo-ticker global-module flex flex-col items-center gap-8 lg:gap-10 overflow-hidden"
  >
    <h2
      v-if="title"
      class="text-xs uppercase text-center font-secondary text-black tracking-default"
    >
      {{ title }}
    </h2>

    <div
      ref="containerRef"
      class="marquee-container"
      :style="{ '--marquee-duration': `${duration}s` }"
    >
      <!-- two identical copies create the seamless loop -->
      <div
        v-for="copy in 2"
        :key="copy"
        class="marquee"
      >
        <div
          ref="childRefs"
          class="marquee-child"
        >
          <div
            v-for="(logo, index) in repeatedLogos"
            :key="index"
            class="child"
          >
            <DefImage :image-data="logo" />
          </div>
        </div>
      </div>
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
const title = computed(() => props.module?.title)
const logos = computed(() => props.module?.logos?.nodes ?? [])

// refs / state
const containerRef = ref(null)
const childRefs = ref([])
const repeat = ref(1)
const duration = ref(20)
const speed = 20 // pixels per second

// repeat the logo set enough times to always fill the container
const repeatedLogos = computed(() => {
  const out = []
  for (let i = 0; i < repeat.value; i++) {
    out.push(...logos.value)
  }
  return out
})

const computeLayout = async () => {
  if (!containerRef.value || !childRefs.value.length) return

  // measure a single set: reset to one repeat first
  repeat.value = 1
  await nextTick()

  const child = childRefs.value[0]
  const setWidth = child.getBoundingClientRect().width
  const containerWidth = containerRef.value.getBoundingClientRect().width

  if (!setWidth) return

  // enough copies to overflow the container (+1 buffer so it's never short)
  repeat.value = Math.max(1, Math.ceil(containerWidth / setWidth) + 1)

  // keep scroll speed constant regardless of total width
  duration.value = (setWidth * repeat.value) / speed
}

// wait for logo images to load so width measurements are accurate
const waitForImages = () => {
  if (!containerRef.value) return Promise.resolve()

  const imgs = Array.from(containerRef.value.querySelectorAll('img'))
  return Promise.all(
    imgs.map((img) =>
      img.complete
        ? Promise.resolve()
        : new Promise((resolve) => {
            img.addEventListener('load', resolve, { once: true })
            img.addEventListener('error', resolve, { once: true })
          }),
    ),
  )
}

onMounted(async () => {
  await nextTick()
  await waitForImages()
  await computeLayout()
  window.addEventListener('resize', computeLayout)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', computeLayout)
})
</script>

<style scoped lang="postcss">
.global-logo-ticker {
  padding: 5rem 0;

  @media screen and (min-width: 1024px) {
    padding: 6rem 0;
  }

  .marquee-container {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    width: 100%;
    overflow-x: hidden;
  }

  .marquee {
    flex: 0 0 auto;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    width: auto;
    min-width: auto;
    animation: scroll var(--marquee-duration, 20s) linear infinite;
  }

  .marquee-child {
    flex: 0 0 auto;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 4rem;
    /* match the internal gap at the seam between the two copies */
    padding-right: 6rem;
    min-width: auto;
  }

  .child {
    flex: 0 0 auto;
    display: flex;
    align-items: center;
  }
}

.global-logo-ticker .child :deep(img) {
  height: 18px;
  width: auto;
}

@keyframes scroll {
  0% {
    transform: translateX(0%);
  }

  100% {
    transform: translateX(-100%);
  }
}
</style>
