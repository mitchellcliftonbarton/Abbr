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

  runtimeConfig: {
    public: {
      graphqlEndpoint: process.env.GRAPHQL_ENDPOINT_DEV,
      allowedHostnames: ['localhost:3000', '127.0.0.1', 'abbr.warm-rice.dev', 'abbr-projects.local'],
    },
  },
})
