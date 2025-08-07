export default defineNuxtPlugin(async () => {
  const config = useRuntimeConfig()

  console.log(config)

  // Fetch default meta data from GraphQL
  const response = await fetch(config.public.graphqlEndpoint, {
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
                    filePath
                  }
                }
              }
            }
          }
        }
      `,
    }),
  })

  console.log('meta-defaults response', response)

  const { data } = await response.json()

  console.log('meta-defaults data', data)

  const { metaDescription, ogImage } = data?.global?.globalData
  const title = 'Abbr. Projects'

  // Set default meta tags
  useSeoMeta({
    title: title,
    titleTemplate: '%s | Abbr. Projects',
    description: metaDescription,
    ogTitle: title,
    ogDescription: metaDescription,
    ogImage: ogImage?.node?.mediaDetails?.filePath,
    ogType: 'website',
  })
})
