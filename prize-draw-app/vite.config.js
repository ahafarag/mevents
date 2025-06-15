import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': 'bootstrap',
            // We removed '~admin-lte' and '~@fortawesome' aliases from here
            // as we are now importing them directly in JS
        },
    },
});
