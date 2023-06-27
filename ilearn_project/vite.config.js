import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath } from 'url'

import dns from 'dns'

dns.setDefaultResultOrder('verbatim')

export default defineConfig({
    "vite": "^3.1.0",
    build: {
        rollupOptions: {
          input: {
            ProductionAnnouncement: fileURLToPath(new URL('./resources/js/announcement.js', import.meta.url)),
            ProductionAuditTrail: fileURLToPath(new URL('./resources/js/audit_trail.js', import.meta.url)),
            ProductionCategories: fileURLToPath(new URL('./resources/js/categories.js', import.meta.url)),
            ProductionGlossary: fileURLToPath(new URL('./resources/js/glossary.js', import.meta.url)),
            ProductionHome: fileURLToPath(new URL('./resources/js/home.js', import.meta.url)),
            ProductionLoginform: fileURLToPath(new URL('./resources/js/login_form.js', import.meta.url)),
            ProductionMasterlist: fileURLToPath(new URL('./resources/js/master_list.js', import.meta.url)),
            ProductionMyProfile: fileURLToPath(new URL('./resources/js/my_profile.js', import.meta.url)),
            ProductionNewGlossary: fileURLToPath(new URL('./resources/js/new_glossary.js', import.meta.url)),
            ProductionNewUploadforms: fileURLToPath(new URL('./resources/js/new_uploadforms.js', import.meta.url)),
            ProductionPolicy: fileURLToPath(new URL('./resources/js/policy_v1.js', import.meta.url)),
            ProductionTitleLink: fileURLToPath(new URL('./resources/js/title_link.js', import.meta.url)),
            ProductionUploadform: fileURLToPath(new URL('./resources/js/uploadforms.js', import.meta.url)),
            ProductionUserManagement: fileURLToPath(new URL('./resources/js/user_management.js', import.meta.url)),
            ProductionLinkForm: fileURLToPath(new URL('./resources/js/link_form.js', import.meta.url)),
            ProductionSection: fileURLToPath(new URL('./resources/js/section.js', import.meta.url)),
            ProductionDepartment: fileURLToPath(new URL('./resources/js/department.js', import.meta.url)),
            ProductionForgotPassword: fileURLToPath(new URL('./resources/js/forgot_password.js', import.meta.url)),
            ProductionSearchBar: fileURLToPath(new URL('./resources/js/search_bar.js', import.meta.url)),
            
            
          },
        },
      },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
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