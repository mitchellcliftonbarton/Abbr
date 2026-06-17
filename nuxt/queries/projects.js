import { fetchGraphql } from '~/lib/graphql'

export async function getProjectsData({ runTimeConfig }) {
  const query = `
        {
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
                            width
                            height
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
          projects(first: 1000) {
            nodes {
              id
              slug
              title
              projectData {
                mainImage {
                  node {
                    altText
                    mediaItemUrl
                    mediaDetails {
                      width
                      height
                      sizes(include: [CUSTOM_LG, CUSTOM_MD]) {
                        sourceUrl
                        width
                        name
                      }
                    }
                  }
                }
                archiveLink {
                  url
                }
                archiveCredit
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
      `

  return fetchGraphql({ runTimeConfig, query })
}
