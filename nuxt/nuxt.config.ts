import tailwindcss from '@tailwindcss/vite'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  /*
  Defaults
  */

  app: {
    head: {
      link: [
        { rel: 'icon', type: 'image/png', href: '/favicon.png' },
        // warm up the connection to the WP media/GraphQL host
        { rel: 'preconnect', href: 'https://admin.abbrprojects.com', crossorigin: '' },
        { rel: 'dns-prefetch', href: 'https://admin.abbrprojects.com' },
      ],
    },
  },

  vite: {
    plugins: [tailwindcss()],
  },

  plugins: ['~/plugins/server/meta-defaults.js'],

  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },
  modules: ['@nuxt/eslint', 'nuxt-gtag'],
  css: ['~/assets/css/main.css'],

  gtag: {
    id: 'G-H6XXJ8XF13',
  },

  // Cache rendered HTML at the edge. swr = serve the last good render instantly
  // and revalidate in the background; if revalidation fails (e.g. upstream 403/502),
  // the previously cached page is still served instead of a 500.
  routeRules: {
    '/': { swr: 1800 }, // 30 min
    '/projects': { swr: 1800 },
    '/projects/**': { swr: 1800 },
  },

  runtimeConfig: {
    public: {
      graphqlEndpoint: process.env.GRAPHQL_ENDPOINT_DEV,
      // Hostnames treated as internal by DynamicLink.vue (SPA nav, same tab).
      // Anything else is treated as external and opens in a new tab.
      // Note: URL.hostname never includes a port, so use 'localhost' not 'localhost:3000'.
      allowedHostnames: [
        'abbrprojects.com',
        'localhost',
        '127.0.0.1',
        'abbr.warm-rice.dev',
        'abbr-projects.local',
      ],
    },
  },
})
