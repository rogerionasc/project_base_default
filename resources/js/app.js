import '../css/dist/css/tabler-vendors.min.css';
import '../css/dist/css/tabler.min.css';
import '../css/dist/js/tabler.esm.min.js';
import '../css/dist/custom.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import FlashMessage from '../js/Components/FlashMessage.vue';
import axios from 'axios';

const appName = import.meta.env.VITE_APP_NAME;

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

createInertiaApp({
    title: (title) => `${appName} - ${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component('FlashMessage', FlashMessage)
            .mount(el);

    },
    progress: {
        color: '#4B5563',
    },
});
