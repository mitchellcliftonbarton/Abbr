<template>
  <nuxt-link
    :to="link"
    class="flex items-center project-filter-link"
    :class="{ active }"
  >
    <span>{{ category.name }}</span>

    <div class="num-container w-[15px]">
      <span
        v-if="!active"
        class="pl-1 number text-xs"
        >{{ category.count }}</span
      >
      <X
        v-else
        class="pl-1"
      />
    </div>
  </nuxt-link>
</template>

<script setup>
import X from '~/components/X.vue'

// define props
const props = defineProps({
  category: {
    type: Object,
    required: true,
  },
})

const route = useRoute()

const active = computed(() => {
  return route.query.service === props.category.slug
})

const link = computed(() => {
  return active.value ? `/projects` : `/projects?service=${props.category.slug}`
})
</script>
