import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import vue from '@vitejs/plugin-vue2';
import { createVuePlugin } from 'vite-plugin-vue2';


export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        createVuePlugin(),
    ],
    server: {
        hmr: {
            host: "localhost",
            protocol: "ws",
        },
    },
});
