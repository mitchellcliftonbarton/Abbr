import { fetchGraphql } from '~/lib/graphql'

export async function getGlobalData({ runTimeConfig }) {
  const query = `
        {
          global {
            globalData {
              metaDescription
              ogImage {
                node {
                  mediaDetails {
                    width
                    height
                    sizes(include: [CUSTOM_XXL]) {
                      sourceUrl
                    }
                  }
                  mediaItemUrl
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
          }
        }
      `

  return fetchGraphql({ runTimeConfig, query })
}
