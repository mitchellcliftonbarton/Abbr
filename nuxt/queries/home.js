export async function getPageData({ runTimeConfig, url }) {
  const response = await fetch(runTimeConfig.public.graphqlEndpoint, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      query: `
        {
          page(id: "${url}", idType: URI) {
            title
            home {
              modules {
                ... on HomeModulesIdeasListLayout {
                  type
                  fieldGroupName
                  featuredIdeas {
                    nodes {
                      id
                      slug
                      ... on Post {
                        id
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
                }
                ... on HomeModulesMiniCarouselLayout {
                  carouselTitle
                  fieldGroupName
                  carouselItems {
                    ... on HomeModulesCarouselItemsCarouselItemLayout {
                      author
                      quote
                      source
                    }
                  }
                  carouselLink {
                    target
                    title
                    url
                  }
                  backgroundImage {
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
                ... on HomeModulesGroupedListLayout {
                  headline
                  fieldGroupName
                  groups {
                    ... on HomeModulesGroupsGroupItemLayout {
                      subtitle
                      text
                      title
                      link {
                        target
                        title
                        url
                      }
                    }
                  }
                  eyebrowLink {
                    target
                    title
                    url
                  }
                }
                ... on HomeModulesFeaturedProjectsLayout {
                  fieldGroupName
                  headline
                  projects {
                    ... on HomeModulesProjectsProjectItemLayout {
                      text
                      image {
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
                      project {
                        nodes {
                          ... on Project {
                            id
                            title
                            slug
                          }
                        }
                      }
                    }
                  }
                }
                ... on HomeModulesTextImageLayout {
                  headline
                  fieldGroupName
                  text
                  link {
                    target
                    title
                    url
                  }
                  image {
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
                ... on HomeModulesFullWidthMediaLayout {
                  type
                  fieldGroupName
                  videoMp4Mobile {
                    node {
                      mediaItemUrl
                    }
                  }
                  videoMp4 {
                    node {
                      mediaItemUrl
                    }
                  }
                  imageMobile {
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
                  image {
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
        }
      `,
    }),
  })

  const res = await response.json()

  return res.data
}
