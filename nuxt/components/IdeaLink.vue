<template>
  <nuxt-link
    :href="link"
    :data-slug="slug"
    class="idea-link flex-none aspect-[6/2] w-[200px] relative border border-grey-2 rounded-xl overflow-hidden"
    :class="{ active: isActive }"
    @click.prevent="handleClick"
  >
    <div class="inner flex">
      <div class="view">
        <p class="font-secondary uppercase text-xs p-2">View</p>
      </div>

      <div class="image h-full relative">
        <DefImage
          :image-data="mainImage"
          class="w-full h-full object-cover lazyload"
        />
      </div>

      <div class="titles text-sm leading-[1.2] p-2">
        <p
          v-html="title"
          class="text-black line-clamp-2"
        ></p>

        <div
          v-if="wordCount && wordCount > 0"
          class="text-grey-3"
        >
          {{ wordCount }} words
        </div>
      </div>
    </div>
  </nuxt-link>
</template>

<script setup>
import DefImage from '~/components/DefImage.vue'

// route
const route = useRoute()
const router = useRouter()

const emit = defineEmits(['idea-click'])

// define props
const props = defineProps({
  idea: {
    type: Object,
    required: true,
  },
  index: {
    type: Number,
    required: true,
  },
})

// computed
const slug = computed(() => props.idea.slug)
const mainImage = computed(() => props.idea.idea.mainImage?.node)
const title = computed(() => props.idea.title)
const wordCount = computed(() => props.idea.idea.text.split(' ').length)
const text = computed(() => props.idea.idea.text)
const link = computed(() => `/?idea=${slug.value}`)

const isActive = computed(() => {
  if (props.index === 0) {
    return route.query.idea === slug.value || !route.query.idea
  }

  return route.query.idea === slug.value
})

const handleClick = () => {
  // emit an event to the parent
  emit('idea-click')

  router.push(link.value)
}
</script>

<style scoped lang="postcss">
.idea-link {
  background-color: white;

  .view {
    width: 75%;
    flex: none;
    background-color: var(--color-grey-1);

    p {
      display: flex;
      align-items: center;
      gap: 0.5rem;

      &::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--color-green);
        transform: translateY(0.08em);
      }
    }
  }

  .image {
    width: 25%;
    flex: none;
  }

  .titles {
    width: 75%;
    flex: none;
    transition: background-color 0.2s;
  }

  .inner {
    transition: transform 0.2s;
    transform: translateX(-75%);
  }

  &:hover {
    .inner {
      transform: translateX(0%);
    }
  }

  &.active {
    .titles {
      background-color: var(--color-green);
    }
  }
}
</style>
