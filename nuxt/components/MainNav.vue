<template>
  <header
    id="main-nav"
    class="fixed top-0 left-0 px-8 py-6 flex justify-between items-center w-full font-semibold"
  >
    <nuxt-link
      to="/"
      class="block"
      >Abbreviated</nuxt-link
    >

    <div
      v-if="route.name === 'projects'"
      class="flex items-center gap-8"
    >
      <nuxt-link
        v-for="category in serviceCategories"
        :key="category.slug"
        :to="`/projects?service=${category.slug}`"
        class="block project-filter-link"
      >
        <span>{{ category.name }}</span>
        <sup class="pl-1">{{ category.count }}</sup>
      </nuxt-link>
    </div>

    <nuxt-link
      v-else
      to="/projects"
      class="block"
      >Projects</nuxt-link
    >
  </header>
</template>

<script setup>
const route = useRoute()

// get service categories
const serviceCategories = useState('serviceCategories')
</script>

<style scoped lang="postcss">
#main-nav {
  mix-blend-mode: exclusion;
  color: white;
  z-index: 1000;

  .project-filter-link {
    sup {
      opacity: 0.5;
      font-weight: 400;
    }
  }

  a {
    transition: opacity 0.2s;

    &:hover {
      opacity: 0.5;
    }
  }
}
</style>
