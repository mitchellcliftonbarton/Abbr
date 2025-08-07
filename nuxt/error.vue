<script setup>
const props = defineProps({
  error: Object,
})

const handleError = () => clearError({ redirect: '/' })

console.log(props.error)
</script>

<template>
  <div>
    <h2>{{ error?.statusCode }}</h2>
    <p>{{ error?.message }}</p>
    <p>{{ error?.statusMessage }}</p>
    <p>{{ error?.data }}</p>
  </div>
</template>
