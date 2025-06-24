<template>
  <button
    @click.prevent="handleCopy"
    class="circle-link"
    :class="{ 'pointer-events-none': buttonText }"
  >
    <div
      v-if="!buttonText"
      class="text-content"
    >
      <div>Share</div>
      <div>Share</div>
    </div>

    <p v-else>{{ buttonText }}</p>
  </button>
</template>

<script setup>
// define props
const props = defineProps({
  text: {
    type: String,
    required: true,
  },
})

// refs
const buttonText = ref(null)

// handle copy
const handleCopy = () => {
  navigator.clipboard.writeText(props.text)
  buttonText.value = 'Link Copied'

  setTimeout(() => {
    buttonText.value = null
  }, 2000)
}
</script>
