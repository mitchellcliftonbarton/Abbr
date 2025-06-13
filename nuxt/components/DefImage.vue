<template>
  <img
    v-if="imageData"
    ref="imgRef"
    :alt="altValue"
    :srcset="srcset"
    :sizes="sizes"
    @load="handleLoad"
    :class="{ loaded }"
  />
  <img
    v-else-if="src"
    ref="imgRef"
    :src="src"
    :alt="altValue"
    @load="handleLoad"
    :class="{ loaded }"
  />
</template>

<script setup>
// define props
const props = defineProps({
  imageData: Object,
  alt: String,
  src: String,
})

// get alt value
const altValue = computed(() => props.alt || props.imageData?.altText)

// get srcset value
const srcset = computed(() => {
  if (!props.imageData) return false

  // start with empty array
  const srcset = []

  // loop through imageData sizes
  props.imageData?.mediaDetails?.sizes.forEach((size) => {
    srcset.push(`${size.sourceUrl} ${size.width}w`)
  })

  // check if sizes array contains the mediaItemUrl
  const sizesContainsMediaItemUrl = props.imageData?.mediaDetails?.sizes.some(
    (size) => size.sourceUrl === props.imageData?.mediaItemUrl
  )

  // add full file as last size if it's not already in the sizes array
  if (props.imageData?.mediaItemUrl && !sizesContainsMediaItemUrl) {
    srcset.push(`${props.imageData?.mediaItemUrl} 100w`)
  }

  // return srcset as string
  return srcset.join(', ')
})

// get sizes value
const sizes = computed(() => {
  if (!props.imageData) return null

  // start with empty array
  const sizes = []

  // loop through imageData sizes
  props.imageData?.mediaDetails?.sizes.forEach((size) => {
    sizes.push(`(max-width: ${size.width}px) ${size.width}px`)
  })

  // add 100vw as last size
  sizes.push('100vw')

  // return sizes as string
  return sizes.join(', ')
})

// refs/vars
const imgRef = ref(null)
const loaded = ref(false)

// methods
const handleLoad = () => {
  loaded.value = true
}

// handle cached images and srcset
// listens for complete event on imgRef
watch(
  () => imgRef.value?.complete,
  (newVal) => {
    if (newVal) {
      handleLoad()
    }
  },
  {
    deep: true,
    immediate: true,
  }
)
</script>
