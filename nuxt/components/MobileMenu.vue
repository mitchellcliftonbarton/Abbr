<template>
  <div
    class="mobile-menu fixed top-0 left-0 w-full h-full z-20"
    :class="{ active: mobileMenuOpen }"
  >
    <button
      class="fill-parent"
      @click="mobileMenuOpen = false"
    ></button>

    <div class="menu-container pt-32 px-4 pb-20 flex flex-col gap-4 items-center">
      <FilterLink
        v-for="category in serviceCategories"
        :key="category.slug"
        :category="category"
        class="uppercase font-medium"
        @click.native="mobileMenuOpen = false"
      />
    </div>
  </div>
</template>

<script setup>
import FilterLink from '~/components/FilterLink.vue'

// get service categories
const serviceCategories = useState('serviceCategories')

// get mobile menu open state
const mobileMenuOpen = useState('mobileMenuOpen')
</script>

<style lang="postcss">
.mobile-menu {
  pointer-events: none;

  .menu-container {
    background-color: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(30px);
    transform: translateY(-100%);
    transition: transform 0.2s;
  }

  &.active {
    pointer-events: auto;

    .menu-container {
      transform: translateY(0);
    }
  }

  .project-filter-link {
    opacity: 0.5;
    transition:
      opacity 0.2s,
      color 0.2s;

    .num-container {
      display: flex;
      align-items: center;
      justify-content: center;
      transform: translateY(-0.15em);
      opacity: 0.7;
    }

    .number {
      font-weight: 400;
    }

    svg {
      width: 12px;
      transform: translateY(0.05em);
    }

    &.active {
      opacity: 1;
      color: var(--color-green);
    }
  }
}
</style>
