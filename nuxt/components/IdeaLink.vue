<template>
  <nuxt-link
    :href="link"
    :data-slug="slug"
    class="idea-link flex-none aspect-[6/2] w-[200px] relative grid grid-cols-4 border border-grey-2 rounded-xl overflow-hidden"
    :class="{ active: isActive }"
    @click.prevent="handleClick"
  >
    <div class="col-span-1 h-full relative">
      <DefImage
        :image-data="mainImage"
        class="w-full h-full object-cover lazyload"
      />
    </div>

    <div class="col-span-3 text-sm leading-[1.2] p-2">
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
})

// computed
const slug = computed(() => props.idea.slug)
const mainImage = computed(() => props.idea.idea.mainImage?.node)
const title = computed(() => props.idea.title)
const wordCount = computed(() => props.idea.idea.text.split(' ').length)
const text = computed(() => props.idea.idea.text)
const link = computed(() => `/?idea=${slug.value}`)

const isActive = computed(() => route.query.idea === slug.value)

const handleClick = () => {
  // emit an event to the parent
  emit('idea-click')

  router.push(link.value)
}
</script>
