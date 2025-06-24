<template>
  <div class="px-8">
    <section class="grid grid-cols-12 gap-8">
      <div class="intro col-span-6 pt-20 enter-in-fade-up animation-delay-100">
        <div class="font-medium">
          <p>for</p>
          <h1>{{ clientName ?? projectTitle }}</h1>
        </div>

        <div
          v-if="introText"
          class="rich-text mt-4 text-black tracking-[-.02em] leading-none font-medium w-1/2"
          v-html="introText"
        ></div>

        <div
          v-if="services"
          class="services"
        >
          <h2 class="square-title uppercase text-grey-2 font-secondary text-sm">Services</h2>

          <div
            class="rich-text mt-4 text-sm uppercase font-medium leading-none"
            v-html="services"
          ></div>
        </div>

        <div
          v-if="team"
          class="team"
        >
          <h2 class="square-title uppercase text-grey-2 font-secondary text-sm">Team</h2>

          <div
            class="rich-text mt-4 text-sm uppercase font-medium leading-none"
            v-html="team"
          ></div>
        </div>
      </div>

      <div
        v-if="mainImage"
        class="enter-in-fade-up animation-delay-200 col-span-6 pt-6"
      >
        <figure class="aspect-[4/5] w-[70%] mx-auto rounded-2xl overflow-hidden bg-grey-1">
          <DefImage
            :image-data="mainImage"
            class="w-full h-full object-cover"
          />
        </figure>
      </div>
    </section>

    <ProjectModule
      v-for="(module, index) in modules"
      :key="module.id"
      :module="module"
      class="enter-in-fade-up"
      :style="{ animationDelay: `${index * 100 + 200}ms` }"
    />
  </div>
</template>

<script setup>
import { getProjectDetailData } from '~/queries/projectDetail'

// get runtime config
const runTimeConfig = useRuntimeConfig()

// get route
const route = useRoute()

// get project detail data
const { data } = await useAsyncData('projectDetailData', () =>
  getProjectDetailData({ runTimeConfig, slug: route.params.slug })
)

// computed
const projectTitle = computed(() => {
  return data.value?.project?.title
})

const clientName = computed(() => {
  return data.value?.project?.projectData?.clientName
})

const introText = computed(() => {
  return data.value?.project?.projectData?.introText
})

const services = computed(() => {
  return data.value?.project?.projectData?.services
})

const team = computed(() => {
  return data.value?.project?.projectData?.team
})

const modules = computed(() => {
  return data.value?.project?.projectData?.modules
})

const mainImage = computed(() => {
  return data.value?.project?.projectData?.mainImage?.node
})
</script>

<style scoped lang="postcss">
.intro {
  & > * + * {
    margin-top: 1em;
  }
}

section + section {
  margin-top: 5rem;
}
</style>
