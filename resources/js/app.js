import '../css/app.css';
import './bootstrap';
import './icons.js';
import 'vue3-toastify/dist/index.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Vue3Toastify from 'vue3-toastify';
import { toast } from 'vue3-toastify';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component('font-awesome-icon', FontAwesomeIcon)
            .use(plugin)
            .use(ZiggyVue)
            .use(Vue3Toastify,
                {
                  autoClose: 3000,
                  position: toast.POSITION.BOTTOM_RIGHT
                })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
