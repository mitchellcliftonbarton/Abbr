// Server-side stub for v-video-in-view.
// The directive does nothing during SSR — it only activates on the client
// (via video-in-view.client.js). Vue's SSR renderer requires getSSRProps to
// be defined on any directive used in a server-rendered template.
export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.vueApp.directive('video-in-view', {
    getSSRProps() {
      return {}
    },
  })
})
