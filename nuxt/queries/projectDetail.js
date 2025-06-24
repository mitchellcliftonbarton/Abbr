export async function getProjectDetailData({ runTimeConfig, slug }) {
  const response = await fetch(runTimeConfig.public.graphqlEndpoint, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      query: `
        {
          project(id: "${slug}", idType: SLUG) {
            title(format: RENDERED)
            projectData {
              clientName
              introText
              services
              team
              mainImage {
                node {
                  altText
                  mediaItemUrl
                  mediaDetails {
                    width
                    height
                    sizes(include: [CUSTOM_XXL, CUSTOM_XL, CUSTOM_LG, CUSTOM_MD]) {
                      sourceUrl
                      width
                      name
                    }
                  }
                }
              }
              mainVideo {
                node {
                  mediaItemUrl
                  mediaDetails {
                    width
                    height
                  }
                }
              }
              modules {
                ... on ProjectDataModulesMediaLayout {
                  fieldGroupName
                  caption
                  title
                  image {
                    node {
                      altText
                      mediaItemUrl
                      mediaDetails {
                        width
                        height
                        sizes(include: [CUSTOM_XXL, CUSTOM_XL, CUSTOM_LG, CUSTOM_MD]) {
                          sourceUrl
                          width
                          name
                        }
                      }
                    }
                  }
                  video {
                    node {
                      mediaItemUrl
                      mediaDetails {
                        width
                        height
                      }
                    }
                  }
                }
                ... on ProjectDataModulesCarouselLayout {
                  fieldGroupName
                  caption
                  title
                  carouselMedia(first: 100) {
                    nodes {
                      altText
                      mediaItemUrl
                      mimeType
                      mediaDetails {
                        width
                        height
                        sizes(include: [CUSTOM_XXL, CUSTOM_XL, CUSTOM_LG, CUSTOM_MD]) {
                          sourceUrl
                          width
                          name
                        }
                      }
                    }
                  }
                }
              }
              relatedProjects(first: 100) {
                nodes {
                  ... on Project {
                    id
                    slug
                    title
                    projectData {
                      introText
                      mainImage {
                        node {
                          altText
                          mediaItemUrl
                          mediaDetails {
                            sizes(include: [CUSTOM_LG, CUSTOM_MD]) {
                              sourceUrl
                              width
                              name
                            }
                          }
                        }
                      }
                      mainVideo {
                        node {
                          mediaItemUrl
                          mediaDetails {
                            width
                            height
                          }
                        }
                      }
                    }
                    projectServiceCategories {
                      nodes {
                        name
                        slug
                      }
                    }
                    projectSectors {
                      nodes {
                        name
                        slug
                      }
                    }
                  }
                }
              }
            }
            projectServiceCategories {
              nodes {
                name
                slug
              }
            }
          }
          global {
            globalData {
              featuredProjects(first: 1000) {
                nodes {
                  ... on Project {
                    id
                    slug
                    title
                    projectData {
                      introText
                      mainImage {
                        node {
                          altText
                          mediaItemUrl
                          mediaDetails {
                            sizes(include: [CUSTOM_LG, CUSTOM_MD]) {
                              sourceUrl
                              width
                              name
                            }
                          }
                        }
                      }
                      mainVideo {
                        node {
                          mediaItemUrl
                          mediaDetails {
                            width
                            height
                          }
                        }
                      }
                    }
                    projectServiceCategories {
                      nodes {
                        name
                        slug
                      }
                    }
                    projectSectors {
                      nodes {
                        name
                        slug
                      }
                    }
                  }
                }
              }
            }
          }
        }
      `,
    }),
  })

  const res = await response.json()

  const data = res.data

  // get all featured projects
  const allFeaturedProjects = data.global.globalData?.featuredProjects?.nodes || []
  const relatedProjects = data.project.projectData.relatedProjects?.nodes || []

  if (allFeaturedProjects.length > 0 && relatedProjects.length === 0) {
    // pick 3 random projects from allFeaturedProjects, excluding current project
    const filteredProjects = allFeaturedProjects.filter((project) => project.slug !== slug)
    const randomProjects = filteredProjects.sort(() => Math.random() - 0.5).slice(0, 3)

    data.project.projectData.relatedProjects = randomProjects
  }

  return data
}
