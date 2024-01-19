import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/admin.css',
                'resources/css/app.css',
                'resources/css/admin/*.*',
                'resources/js/app.js',
                'resources/js/admin/*.*',
            ],
            refresh: true,
        }),
    ],
});
