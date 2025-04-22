import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        https: true, // Enable HTTPS in development if needed
        hmr: {
            host: 'orbitsv12-production.up.railway.app',
        },
    },
    build: {
        manifest: true,
    },
});