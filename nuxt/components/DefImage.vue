<template>
  <img
    v-if="srcset"
    ref="imgRef"
    :alt="altValue"
    :srcset="srcset"
    :sizes="sizes"
    :loading="loadingValue"
    decoding="async"
    :fetchpriority="priority ? 'high' : undefined"
    @load="handleLoad"
    :class="{ loaded }"
  />
  <img
    v-else-if="src"
    ref="imgRef"
    :src="src"
    :alt="altValue"
    :loading="loadingValue"
    decoding="async"
    :fetchpriority="priority ? 'high' : undefined"
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
  // above-the-fold images should load eagerly to protect LCP
  priority: {
    type: Boolean,
    default: false,
  },
  // optional override for the native loading attribute
  loading: String,
})

// get alt value
const altValue = computed(() => props.alt || props.imageData?.altText)

// native loading attribute: eager for priority/hero images, lazy otherwise
const loadingValue = computed(() => (props.priority ? 'eager' : props.loading || 'lazy'))

// get srcset value
const srcset = computed(() => {
  if (!props.imageData) return false

  // start with empty array
  const srcset = []

  // loop through imageData sizes
  props?.imageData?.mediaDetails?.sizes?.forEach((size) => {
    srcset.push(`${size.sourceUrl} ${size.width}w`)
  })

  // check if sizes array contains the mediaItemUrl
  const sizesContainsMediaItemUrl = props.imageData?.mediaDetails?.sizes?.some(
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

  // Use a more predictable sizes string that doesn't depend on dynamic data
  // This prevents hydration mismatches between server and client
  return '(max-width: 768px) 768px, (max-width: 1024px) 1024px, 100vw'
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
