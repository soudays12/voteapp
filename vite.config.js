
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'


export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.js', 'resources/css/app.css', 'fontawesome/css/app.css'], // Mettez à jour avec vos fichiers
      refresh: true,
    }),
  ],
});
