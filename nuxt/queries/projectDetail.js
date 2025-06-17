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
              modules {
                ... on ProjectDataModulesMediaLayout {
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
