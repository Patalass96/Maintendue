import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/home.css',
                'resources/css/dashboard.css', 
                'resources/css/profile.css',
                'resources/css/admin.css',
                'resources/css/component.css',
                'resources/css/auth.css',
                'resources/js/form.js',        
                'resources/js/app.js',
                'resources/js/home.js',          
            ],
            refresh: true,
        }),
    ],
});