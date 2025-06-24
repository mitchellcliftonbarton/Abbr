import tailwindcss from '@tailwindcss/vite'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  /*
  Defaults
  */

  vite: {
    plugins: [tailwindcss()],
  },

  plugins: ['~/plugins/server/meta-defaults.js'],

  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },
  modules: ['@nuxt/eslint'],
  css: ['~/assets/css/main.css'],

  runtimeConfig: {
    public: {
      graphqlEndpoint: process.env.GRAPHQL_ENDPOINT_DEV,
      allowedHostnames: ['localhost:3000', '127.0.0.1', 'abbr.warm-rice.dev', 'abbr-projects.local'],
    },
  },
})
