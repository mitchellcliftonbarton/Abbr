<template>
  <section class="pt-40">
    <div
      v-if="featuredProjectsToShow.length > 0"
      class="featured-projects grid grid-cols-3"
    >
      <ProjectItem
        v-for="(project, index) in featuredProjectsToShow"
        :key="`featured-${project.id}-${route.fullPath}`"
        :project="project"
        class="enter-in-fade-up"
        :style="{ animationDelay: `${index * 50}ms` }"
      />
    </div>

    <div
      v-if="archiveProjectsToShow.length > 0"
      class="all-projects px-8 enter-in-fade animation-delay-200"
    >
      <h2 class="text-lg text-grey-2 tracking-default leading-none font-medium">Archive</h2>

      <div class="grid grid-cols-6 gap-4 mt-8">
        <ProjectItemAlt
          v-for="(project, index) in archiveProjectsToShow"
          :key="`archive-${project.id}-${route.fullPath}`"
          :project="project"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { getProjectsData } from '~/queries/projects'
import ProjectItem from '~/components/ProjectItem.vue'
import ProjectItemAlt from '~/components/ProjectItemAlt.vue'

// get runtime config
const runTimeConfig = useRuntimeConfig()

// get route
const route = useRoute()

// get current sector
const currentService = computed(() => {
  return route.query.service || false
})

// get projects data
const { data } = await useAsyncData('projectsData', () => getProjectsData({ runTimeConfig }))

// computed
const allFeaturedProjects = computed(() => {
  return data.value?.global?.globalData?.featuredProjects?.nodes || []
})

const allProjects = computed(() => {
  return data.value?.projects?.nodes || []
})

const featuredProjectsToShow = computed(() => {
  if (currentService.value) {
    return allFeaturedProjects.value.filter((project) =>
      project.projectServiceCategories.nodes.some((category) => category.slug === currentService.value)
    )
  }

  return allFeaturedProjects.value
})

const archiveProjectsToShow = computed(() => {
  if (currentService.value) {
    return allProjects.value.filter(
      (project) =>
        !featuredProjectsToShow.value.some((featuredProject) => featuredProject.id === project.id) &&
        project.projectServiceCategories.nodes.some((category) => category.slug === currentService.value)
    )
  }

  return allProjects.value.filter(
    (project) => !featuredProjectsToShow.value.some((featuredProject) => featuredProject.id === project.id)
  )
})

// watch the 'sector' url param route change
watch(
  () => route.query.service,
  () => {
    window.scrollTo(0, 0)
  }
)
</script>

<style scoped lang="postcss">
.featured-projects + .all-projects {
  margin-top: 13rem;
}
</style>
