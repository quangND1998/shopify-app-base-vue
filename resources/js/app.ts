import './bootstrap';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { VueQueryPlugin} from '@tanstack/vue-query';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
import queryClient from '@/queryClient';
import { createPinia } from 'pinia'

const pinia = createPinia()

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .use(VueQueryPlugin, { queryClient })
            .mount(el);
    },
    progress: false,
    // progress: {
    //     color: '#4B5563',
    //     showSpinner: false,
    //     progress: false,
    // },
});
