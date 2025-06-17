<template>
  <svg
    class="logo-icon"
    viewBox="0 0 91 95"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      ref="cross"
      class="cross"
      d="M51.5938 53.9463H39.4062V94.9999H51.5938V53.9463Z"
      fill="currentColor"
    />
    <path
      d="M51.8646 0H39.1354L0 95H12.1875H13L45.5 14.7576L78 95H78.8125H91L51.8646 0Z"
      fill="currentColor"
    />
  </svg>
</template>

<script setup>
import { gsap } from 'gsap/all'

const cross = ref(null)

onMounted(() => {
  const tl = gsap.timeline({ repeat: -1 })

  // Create 8 steps (45 degrees each)
  for (let i = 1; i <= 8; i++) {
    tl.to(cross.value, {
      rotation: i * 45,
      duration: 1,
      ease: 'power3.inOut',
      transformOrigin: 'center',
      delay: i * 0.2,
    })
  }
})

onBeforeUnmount(() => {
  gsap.killTweensOf(cross.value)
})
</script>

<style scoped>
.cross {
  transform-origin: center;
}
</style>
