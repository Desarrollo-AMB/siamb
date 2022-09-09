import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                //'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: { 
        https: true, 
        host: 'localhost', 
    }, 
    resolve: {
        alias: {
            '$': path.resolve(__dirname,'node_modules/jquery'),
            '~bootstrap': path.resolve(__dirname,'node_modules/bootstrap'),
            'select2': 'select2'
        },
    },
});
