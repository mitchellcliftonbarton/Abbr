export default defineNuxtPlugin(async () => {
  const config = useRuntimeConfig()

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

  const { data } = await response.json()

  const { metaDescription, ogImage } = data.global?.globalData
  const title = 'Abbr. Projects'

  console.log('meta-defaults data', metaDescription)
  console.log('meta-defaults ogImage', ogImage?.node?.mediaDetails?.filePath)

  // Set default meta tags
  // useSeoMeta({
  //   title: title,
  //   titleTemplate: '%s | Abbr. Projects',
  //   description: metaDescription,
  //   ogTitle: title,
  //   ogDescription: metaDescription,
  //   ogImage: ogImage?.node?.mediaDetails?.filePath,
  //   ogType: 'website',
  // })
})
