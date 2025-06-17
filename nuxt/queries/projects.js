export async function getProjectsData({ runTimeConfig }) {
  const response = await fetch(runTimeConfig.public.graphqlEndpoint, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      query: `
        {
          global {
            globalData {
              featuredProjects {
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
                    }
                    projectServiceCategories {
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
          projects {
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
                      sizes(include: [CUSTOM_LG, CUSTOM_MD]) {
                        sourceUrl
                        width
                        name
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
          }
        }
      `,
    }),
  })

  const res = await response.json()

  return res.data
}
