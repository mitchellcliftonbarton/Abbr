<template>
  <div id="root">
    <p>Hello</p>
  </div>
</template>

<script setup>
const runTimeConfig = useRuntimeConfig()

onMounted(async () => {
  // run test to see if the graphql endpoint is working
  setTimeout(async () => {
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

    const data = await response.json()

    console.log('layout data', data)
  }, 1000)
})
</script>

<style scoped lang="postcss">
.custom-cursor {
  position: fixed;
  top: 0;
  left: 0;
  transition:
    opacity 0.3s,
    transform 0.08s;
  opacity: 0;
  pointer-events: none;

  &.active {
    opacity: 1;
  }
}
</style>
