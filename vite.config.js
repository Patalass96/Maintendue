import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/notification.css',
                'resources/css/home.css',
                'resources/css/dashboard.css',
                'resources/css/donateur.css',
                'resources/css/association.css',
                'resources/css/admin.css',
                'resources/css/component.css',
                'resources/css/auth.css',
                'resources/js/form.js',
                'resources/js/app.js',
                'resources/js/home.js',
                'resources/js/dashboard.js',
                'resources/js/donations.js',
                'resources/js/association.js',
                'resources/js/profile.js',
                'resources/js/admin.js' ,
                
            ],
            refresh: true,
        }),

        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

    ],

resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },

});
