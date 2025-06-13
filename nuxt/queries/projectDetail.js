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
            }
          }
        }
      `,
    }),
  })

  const res = await response.json()

  return res.data
}
