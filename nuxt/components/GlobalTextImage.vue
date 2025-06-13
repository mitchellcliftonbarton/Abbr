<template>
  <section class="global-text-image global-module px-8">
    <div
      v-if="headline || link"
      class="titles flex justify-between items-center border-b border-grey-2 pb-4"
    >
      <h2
        v-if="headline"
        class="text-lg text-grey-2 tracking-[-.02em] leading-none font-medium"
      >
        {{ headline }}
      </h2>

      <DynamicLink
        v-if="link"
        :href="link.url"
        class="play-link font-secondary uppercase text-xs"
      >
        <Play />
        <span>{{ link.title }}</span>
      </DynamicLink>
    </div>

    <div class="text-content grid grid-cols-12 gap-8">
      <div
        v-if="text"
        class="col-span-12 lg:col-span-8"
      >
        <div
          v-html="text"
          class="text-lg text-black tracking-[-.02em] leading-[1] rich-text font-medium"
        ></div>
      </div>

      <div
        v-if="image"
        class="col-start-10 col-span-3"
      >
        <DefImage
          :image-data="image"
          class="object-cover w-full h-full object-center lazyload overflow-hidden rounded-2xl"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import Play from '~/components/Play.vue'
import DynamicLink from '~/components/DynamicLink.vue'

// define props
const props = defineProps({
  module: {
    type: Object,
    required: true,
  },
})

// define data
const headline = computed(() => props.module?.headline)
const link = computed(() => props.module?.link)
const text = computed(() => props.module?.text)
const image = computed(() => props.module?.image?.node)
</script>

<style scoped lang="postcss">
.titles + .text-content {
  margin-top: 1.8rem;
}
</style>
