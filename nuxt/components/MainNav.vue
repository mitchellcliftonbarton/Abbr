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
      <FilterLink
        v-for="category in serviceCategories"
        :key="category.slug"
        :category="category"
      />
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
import FilterLink from '~/components/FilterLink.vue'

const route = useRoute()

// get service categories
const serviceCategories = useState('serviceCategories')
</script>

<style lang="postcss">
#main-nav {
  mix-blend-mode: exclusion;
  color: white;
  z-index: 1000;

  .project-filter-link {
    transition:
      color 0.2s,
      opacity 0.2s;

    .num-container {
      display: flex;
      align-items: center;
      justify-content: center;
      transform: translateY(-0.05em);
      opacity: 0.7;
    }

    .number {
      /* opacity: 0.7; */
      font-weight: 400;
      /* transform: translateY(-0.35em);
      display: inline-block; */
    }

    &.active {
      color: #ff28e6;
    }

    svg {
      width: 12px;
      transform: translateY(-0.1em);
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
