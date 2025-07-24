<template>
  <header
    id="main-nav"
    class="fixed top-0 left-0 px-4 lg:px-8 py-6 flex justify-between items-center w-full font-medium pointer-events-none"
  >
    <nuxt-link
      to="/"
      class="block pointer-events-auto"
    >
      <span class="hidden md:block">Abbreviated</span>
      <span class="block md:hidden">Abbr.</span>
    </nuxt-link>

    <template v-if="route.name === 'projects'">
      <div class="hidden lg:flex items-center gap-8 pointer-events-auto">
        <FilterLink
          v-for="category in serviceCategories"
          :key="category.slug"
          :category="category"
        />
      </div>

      <button
        class="filter-button flex lg:hidden items-center gap-2 pointer-events-auto"
        :class="{ active: mobileMenuOpen }"
        @click="mobileMenuOpen = !mobileMenuOpen"
      >
        <p>Projects</p>
        <div>
          <Plus />
        </div>
      </button>
    </template>

    <nuxt-link
      v-else
      to="/projects"
      class="block pointer-events-auto"
      >Projects</nuxt-link
    >
  </header>
</template>

<script setup>
import FilterLink from '~/components/FilterLink.vue'
import Plus from '~/components/Plus.vue'
import X from '~/components/X.vue'

const route = useRoute()

// get service categories
const serviceCategories = useState('serviceCategories')

// get mobile menu open state
const mobileMenuOpen = useState('mobileMenuOpen')
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
      transform: translateY(0.05em);
    }
  }

  a:not(.project-filter-link) {
    transition: opacity 0.2s;

    @media screen and (min-width: 1024px) {
      &:hover {
        opacity: 0.5;
      }
    }
  }

  .filter-button {
    & > div {
      display: flex;
      align-items: center;
      justify-content: center;
      transform: translateY(0.05em);
      width: 12px;
      height: 12px;

      .plus-icon {
        display: inline-block;
        width: 12px;
        transition: transform 0.2s;
      }

      /* .x-icon {
        display: none;
        width: 11px;
      } */
    }

    &.active {
      & > div {
        .plus-icon {
          /* display: none; */
          transform: rotate(45deg);
        }

        /* .x-icon {
          display: inline-block;
        } */
      }
    }
  }
}
</style>
