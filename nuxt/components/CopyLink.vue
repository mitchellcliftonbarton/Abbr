<template>
  <button
    @click.prevent="handleCopy"
    :class="{ 'pointer-events-none': copying, 'circle-link': type === 'circle', 'play-link font-secondary uppercase text-xs': type === 'play', 'circle-link circle-link-white': type === 'circle-white' }"
  >
    <Play v-if="type === 'play'" />

    <div
      v-if="!copying"
      class="text-content"
    >
      <div>{{ buttonText }}</div>
      <div>{{ buttonText }}</div>
    </div>

    <p v-else class="text-content">Link Copied</p>
  </button>
</template>

<script setup>
import Play from '~/components/Play.vue'

// define props
const props = defineProps({
  textToCopy: {
    type: String,
    required: true,
  },
  text: {
    type: String,
    required: false,
  },
  type: {
    type: String,
    required: false,
    default: 'circle',
  },
})

// refs
const copying = ref(false)
const buttonText = computed(() => props.text || 'Share')

// handle copy
const handleCopy = () => {
  copying.value = true
  navigator.clipboard.writeText(props.textToCopy)

  setTimeout(() => {
    copying.value = false
  }, 2000)
}
</script>
