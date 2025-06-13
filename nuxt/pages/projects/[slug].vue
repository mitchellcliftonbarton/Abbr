<template>
  <div class="px-8">
    <section class="grid grid-cols-12 gap-8">
      <div class="intro col-span-6 pt-20 enter-in-fade animation-delay-100">
        <div class="font-bold">
          <p>for</p>
          <h1>{{ clientName ?? projectTitle }}</h1>
        </div>

        <div
          v-if="introText"
          class="rich-text mt-4 text-black tracking-[-.02em] leading-none font-bold"
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
    </section>
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
</script>

<style scoped lang="postcss">
.intro {
  & > * + * {
    margin-top: 1em;
  }
}
</style>
