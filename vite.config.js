import { defineConfig } from 'vite'
import path from 'path'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  base: '/wp-content/themes/abbr/dist',
  build: {
    outDir: path.resolve(__dirname, 'themes/abbr/dist'),
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: path.resolve(__dirname, 'src/entry.js'),
      },
      output: {
        entryFileNames: '[name].js', // Prevents adding /assets/
        assetFileNames: '[name][extname]', // Keep assets in root dist/
      },
    },
  },
  plugins: [tailwindcss()],
  server: false,
})
