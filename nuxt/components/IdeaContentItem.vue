<template>
  <div class="idea-content-item grid grid-cols-10 gap-6 px-4 lg:px-6">
    <div class="hidden lg:block col-span-4">
      <figure class="aspect-[4/5] w-full rounded-2xl overflow-hidden">
        <DefImage
          :image-data="mainImage"
          class="w-full h-full object-cover lazyload"
        />
      </figure>
    </div>

    <div class="text-container col-span-10 lg:col-span-6 pb-8">
      <div
        class="text rich-text"
        v-html="text"
      ></div>
    </div>
  </div>
</template>

<script setup>
// define props
const props = defineProps({
  idea: {
    type: Object,
    required: true,
  },
})

const mainImage = computed(() => props.idea.idea.mainImage?.node)
const text = computed(() => props.idea.idea.text)
</script>

<style scoped lang="postcss">
.idea-content-item {
  /* .text-container {
    overflow-y: auto;

    &::-webkit-scrollbar {
      display: none;
    }

    -ms-overflow-style: none;
    scrollbar-width: none;
  } */
}
</style>
