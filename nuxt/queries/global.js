export async function getGlobalData({ runTimeConfig }) {
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
              metaDescription
              ogImage {
                node {
                  mediaDetails {
                    sizes(include: [CUSTOM_XXL]) {
                      sourceUrl
                    }
                  }
                }
              }
              footerTextSub
              footerTextLarge
              footerLinks {
                ... on GlobalDataFooterLinksLinkItemLayout {
                  link {
                    target
                    title
                    url
                  }
                }
              }
            }
          }
          projectServiceCategories {
            nodes {
              name
              slug
              count
            }
          }
          posts(first: 1000) {
            nodes {
              slug
              title
              idea {
                text
                mainImage {
                  node {
                    altText
                    mediaItemUrl
                    mediaDetails {
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
          }
        }
      `,
    }),
  })

  const res = await response.json()

  return res.data
}
