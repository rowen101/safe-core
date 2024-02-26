import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        host: '127.0.0.1',
        port: 3000,
        strictPort: true,
        hmr: {
            port: 443,
        },
    },
    define: {
        // enable hydration mismatch details in production build
        __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: 'true'
      },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

            ],
            // refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                }
            }
        })
    ],
    build: {
        chunkSizeWarningLimit: 1600,
        rollupOptions: {}
      },
});
