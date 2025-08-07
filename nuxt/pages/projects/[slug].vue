<template>
  <div>
    <section class="grid grid-cols-12 gap-8 px-4 lg:px-8">
      <div class="intro col-span-12 lg:col-span-6 pt-20 enter-in-fade-up animation-delay-100">
        <div class="font-medium">
          <p>for</p>
          <h1>{{ clientName ?? projectTitle }}</h1>
        </div>

        <div
          v-if="introText"
          class="rich-text mt-4 text-black tracking-default leading-none font-medium w-full lg:w-1/2"
          v-html="introText"
        ></div>

        <div
          v-if="services"
          class="services"
        >
          <h2 class="uppercase text-grey-2 font-secondary text-sm">Services</h2>

          <div
            class="rich-text mt-2 font-secondary text-sm uppercase"
            v-html="services"
          ></div>
        </div>

        <div
          v-if="team"
          class="team"
        >
          <h2 class="uppercase text-grey-2 font-secondary text-sm">Team</h2>

          <div
            class="rich-text mt-2 font-secondary text-sm uppercase"
            v-html="team"
          ></div>
        </div>
      </div>

      <div
        v-if="mainVideo || mainImage"
        class="enter-in-fade-up animation-delay-200 col-span-12 lg:col-span-6 pt-20 lg:pt-6"
      >
        <figure class="aspect-[4/5] w-full lg:w-[70%] mx-auto rounded-2xl overflow-hidden bg-grey-1">
          <video
            v-if="mainVideo"
            :src="mainVideo"
            class="w-full h-full object-cover"
            autoplay
            muted
            loop
            playsinline
            preload="auto"
          />

          <DefImage
            v-else-if="mainImage"
            :image-data="mainImage"
            class="w-full h-full object-cover"
          />
        </figure>
      </div>
    </section>

    <component
      v-for="(module, index) in modules"
      :key="module.id"
      :module="module"
      class="enter-in-fade-up"
      :style="{ animationDelay: `${index * 100 + 200}ms` }"
      :is="getModuleType(module.fieldGroupName)"
    />

    <section class="related-projects enter-in-fade-up animation-delay-300">
      <div class="px-4 lg:px-8">
        <h2 class="text-lg text-grey-2 tracking-default leading-none font-medium border-b border-black pb-4">
          Related Projects
        </h2>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 pt-[1.8rem]">
        <ProjectItem
          v-for="project in relatedProjects"
          :key="project.id"
          :project="project"
        />
      </div>
    </section>
  </div>
</template>

<script setup>
import { getProjectDetailData } from '~/queries/projectDetail'
import ProjectItem from '~/components/ProjectItem.vue'
import { stripTags } from '~/lib/utils'

// register components
import ProjectMediaModule from '~/components/ProjectMediaModule.vue'
import ProjectCarouselModule from '~/components/ProjectCarouselModule.vue'

// get runtime config
const runTimeConfig = useRuntimeConfig()

// get route
const route = useRoute()

// get project detail data
const { data } = await useAsyncData(`projectDetailData-${route.params.slug}`, () =>
  getProjectDetailData({ runTimeConfig, slug: route.params.slug })
)

const getModuleType = (type) => {
  switch (type) {
    case 'ProjectDataModulesMediaLayout':
      return ProjectMediaModule
    case 'ProjectDataModulesCarouselLayout':
      return ProjectCarouselModule
  }
}

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

const mainVideo = computed(() => {
  return data.value?.project?.projectData?.mainVideo?.node?.mediaItemUrl
})

const relatedProjects = computed(() => {
  return data.value?.project?.projectData?.relatedProjects?.nodes ?? data.value?.project?.projectData?.relatedProjects
})

// Metadata
useMeta({
  title: projectTitle,
  description: introText ? stripTags(introText.value) : null,
  ogImage: mainImage?.value?.mediaItemUrl ?? null,
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
