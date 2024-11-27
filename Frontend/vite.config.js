import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  optimizeDeps:{
    include: ["jwt-decode"],
  },
  plugins: [
    vue(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
  server: {
    proxy: {
      '/api': {
        target: 'http://localhost/Olympus/Backend', // Your backend base URL
        changeOrigin: true, // Ensures the origin of the request is changed to match the target
        rewrite: (path) => path.replace(/^\/api/, ''), // Removes /api prefix before forwarding
      },
    },
    fs: {
      // Include the node_modules folder in the allowed file serving paths
      allow: [
        './src',
        './views',
        './node_modules',
      ],
    },
  },
  build: {
    rollupOptions: {
      input: {
        main: fileURLToPath(new URL('./src/views/LandingPage.vue', import.meta.url)), // Correct path to LandingPage.vue
      },
    },
  },
});
