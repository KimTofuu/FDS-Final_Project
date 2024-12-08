import { fileURLToPath, URL } from "node:url";
import { defineConfig } from "file:///C:/xamppp/htdocs/Olympus/frontend/node_modules/vite/dist/node/index.js";
import vue from "file:///C:/xamppp/htdocs/Olympus/frontend/node_modules/@vitejs/plugin-vue/dist/index.mjs";
var __vite_injected_original_import_meta_url = "file:///C:/xamppp/htdocs/Olympus/frontend/vite.config.js";
var vite_config_default = defineConfig({
  optimizeDeps: {
    include: ["jwt-decode"]
  },
  plugins: [
    vue()
  ],
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", __vite_injected_original_import_meta_url))
    }
  },
  server: {
    proxy: {
      "/api": {
        target: "http://localhost/Olympus/Backend",
        // Your backend base URL
        changeOrigin: true,
        // Ensures the origin of the request is changed to match the target
        rewrite: (path) => path.replace(/^\/api/, "")
        // Removes /api prefix before forwarding
      }
    },
    fs: {
      // Include the node_modules folder in the allowed file serving paths
      allow: [
        "./src",
        "./views",
        "./node_modules"
      ]
    }
  },
  build: {
    rollupOptions: {
      input: {
        main: fileURLToPath(new URL("./src/views/LandingPage.vue", __vite_injected_original_import_meta_url))
        // Correct path to LandingPage.vue
      }
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFx4YW1wcHBcXFxcaHRkb2NzXFxcXE9seW1wdXNcXFxcZnJvbnRlbmRcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXHhhbXBwcFxcXFxodGRvY3NcXFxcT2x5bXB1c1xcXFxmcm9udGVuZFxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzoveGFtcHBwL2h0ZG9jcy9PbHltcHVzL2Zyb250ZW5kL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZmlsZVVSTFRvUGF0aCwgVVJMIH0gZnJvbSAnbm9kZTp1cmwnO1xyXG5pbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJztcclxuaW1wb3J0IHZ1ZSBmcm9tICdAdml0ZWpzL3BsdWdpbi12dWUnO1xyXG5cclxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcclxuICBvcHRpbWl6ZURlcHM6e1xyXG4gICAgaW5jbHVkZTogW1wiand0LWRlY29kZVwiXSxcclxuICB9LFxyXG4gIHBsdWdpbnM6IFtcclxuICAgIHZ1ZSgpLFxyXG4gIF0sXHJcbiAgcmVzb2x2ZToge1xyXG4gICAgYWxpYXM6IHtcclxuICAgICAgJ0AnOiBmaWxlVVJMVG9QYXRoKG5ldyBVUkwoJy4vc3JjJywgaW1wb3J0Lm1ldGEudXJsKSksXHJcbiAgICB9LFxyXG4gIH0sXHJcbiAgc2VydmVyOiB7XHJcbiAgICBwcm94eToge1xyXG4gICAgICAnL2FwaSc6IHtcclxuICAgICAgICB0YXJnZXQ6ICdodHRwOi8vbG9jYWxob3N0L09seW1wdXMvQmFja2VuZCcsIC8vIFlvdXIgYmFja2VuZCBiYXNlIFVSTFxyXG4gICAgICAgIGNoYW5nZU9yaWdpbjogdHJ1ZSwgLy8gRW5zdXJlcyB0aGUgb3JpZ2luIG9mIHRoZSByZXF1ZXN0IGlzIGNoYW5nZWQgdG8gbWF0Y2ggdGhlIHRhcmdldFxyXG4gICAgICAgIHJld3JpdGU6IChwYXRoKSA9PiBwYXRoLnJlcGxhY2UoL15cXC9hcGkvLCAnJyksIC8vIFJlbW92ZXMgL2FwaSBwcmVmaXggYmVmb3JlIGZvcndhcmRpbmdcclxuICAgICAgfSxcclxuICAgIH0sXHJcbiAgICBmczoge1xyXG4gICAgICAvLyBJbmNsdWRlIHRoZSBub2RlX21vZHVsZXMgZm9sZGVyIGluIHRoZSBhbGxvd2VkIGZpbGUgc2VydmluZyBwYXRoc1xyXG4gICAgICBhbGxvdzogW1xyXG4gICAgICAgICcuL3NyYycsXHJcbiAgICAgICAgJy4vdmlld3MnLFxyXG4gICAgICAgICcuL25vZGVfbW9kdWxlcycsXHJcbiAgICAgIF0sXHJcbiAgICB9LFxyXG4gIH0sXHJcbiAgYnVpbGQ6IHtcclxuICAgIHJvbGx1cE9wdGlvbnM6IHtcclxuICAgICAgaW5wdXQ6IHtcclxuICAgICAgICBtYWluOiBmaWxlVVJMVG9QYXRoKG5ldyBVUkwoJy4vc3JjL3ZpZXdzL0xhbmRpbmdQYWdlLnZ1ZScsIGltcG9ydC5tZXRhLnVybCkpLCAvLyBDb3JyZWN0IHBhdGggdG8gTGFuZGluZ1BhZ2UudnVlXHJcbiAgICAgIH0sXHJcbiAgICB9LFxyXG4gIH0sXHJcbn0pO1xyXG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQStSLFNBQVMsZUFBZSxXQUFXO0FBQ2xVLFNBQVMsb0JBQW9CO0FBQzdCLE9BQU8sU0FBUztBQUZtSyxJQUFNLDJDQUEyQztBQUlwTyxJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUMxQixjQUFhO0FBQUEsSUFDWCxTQUFTLENBQUMsWUFBWTtBQUFBLEVBQ3hCO0FBQUEsRUFDQSxTQUFTO0FBQUEsSUFDUCxJQUFJO0FBQUEsRUFDTjtBQUFBLEVBQ0EsU0FBUztBQUFBLElBQ1AsT0FBTztBQUFBLE1BQ0wsS0FBSyxjQUFjLElBQUksSUFBSSxTQUFTLHdDQUFlLENBQUM7QUFBQSxJQUN0RDtBQUFBLEVBQ0Y7QUFBQSxFQUNBLFFBQVE7QUFBQSxJQUNOLE9BQU87QUFBQSxNQUNMLFFBQVE7QUFBQSxRQUNOLFFBQVE7QUFBQTtBQUFBLFFBQ1IsY0FBYztBQUFBO0FBQUEsUUFDZCxTQUFTLENBQUMsU0FBUyxLQUFLLFFBQVEsVUFBVSxFQUFFO0FBQUE7QUFBQSxNQUM5QztBQUFBLElBQ0Y7QUFBQSxJQUNBLElBQUk7QUFBQTtBQUFBLE1BRUYsT0FBTztBQUFBLFFBQ0w7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLE1BQ0Y7QUFBQSxJQUNGO0FBQUEsRUFDRjtBQUFBLEVBQ0EsT0FBTztBQUFBLElBQ0wsZUFBZTtBQUFBLE1BQ2IsT0FBTztBQUFBLFFBQ0wsTUFBTSxjQUFjLElBQUksSUFBSSwrQkFBK0Isd0NBQWUsQ0FBQztBQUFBO0FBQUEsTUFDN0U7QUFBQSxJQUNGO0FBQUEsRUFDRjtBQUNGLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
