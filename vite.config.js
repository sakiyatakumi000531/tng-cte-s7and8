import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/create-confirm.js',
                'resources/js/edit-confirm.js',
                'resources/js/delete-confirm.js',
            ],
            refresh: true,
        }),
    ],
});
