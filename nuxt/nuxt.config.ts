import tailwindcss from '@tailwindcss/vite'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  /*
  Defaults
  */

  app: {
    head: {
      link: [{ rel: 'icon', type: 'image/png', href: '/favicon.png' }],
    },
  },

  vite: {
    plugins: [tailwindcss()],
  },

  nitro: {
    preset: 'cloudflare_module',
    cloudflare: {
      deployConfig: true,
      nodeCompat: true,
      wrangler: {
        name: 'abbr-nuxt',
      },
    },
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
