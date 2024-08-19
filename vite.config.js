import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import svgLoader from 'vite-svg-loader'

export default defineConfig({
  plugins: [
    vue(),
    svgLoader(),
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/style.css'],
      refresh: true
    })
  ],
  base: '/'
})
