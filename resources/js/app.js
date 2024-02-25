import './bootstrap';
import '../css/app.css';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createPinia } from 'pinia';
import piniaPluginPersistedState from "pinia-plugin-persistedstate";
import Load from '@/Components/Load.vue';

const pinia = createPinia();
pinia.use(piniaPluginPersistedState);

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'villa-albertina';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component('Load', Load)
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
