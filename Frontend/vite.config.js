import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

// https://vite.dev/config/
export default defineConfig({
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
  },
});