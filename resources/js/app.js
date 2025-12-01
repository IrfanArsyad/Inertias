import './bootstrap';
import '../css/app.css';

import { createApp, h, defineAsyncComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { InertiaProgress } from '@inertiajs/progress';
import { modal } from 'inertia-modal';

// Import only critical layouts synchronously
import MainLayout from './Layouts/MainLayout.vue';
import GuestLayout from './Layouts/GuestLayout.vue';

// Lazy load components (only loaded when needed)
const DataTable = defineAsyncComponent(() => import('./Components/DataTable.vue'));
const FormInput = defineAsyncComponent(() => import('./Components/FormInput.vue'));
const FormSelect = defineAsyncComponent(() => import('./Components/FormSelect.vue'));
const FormTextarea = defineAsyncComponent(() => import('./Components/FormTextarea.vue'));
const Modal = defineAsyncComponent(() => import('./Components/Modal.vue'));
const Alert = defineAsyncComponent(() => import('./Components/Alert.vue'));
const Pagination = defineAsyncComponent(() => import('./Components/Pagination.vue'));
const Button = defineAsyncComponent(() => import('./Components/Button.vue'));
const Card = defineAsyncComponent(() => import('./Components/Card.vue'));

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        // Check if it's a module page (format: Module::Page)
        if (name.includes('::')) {
            const [module, pagePath] = name.split('::');
            // Capitalize module name (e.g., auth -> Auth)
            const capitalizedModule = module.charAt(0).toUpperCase() + module.slice(1);
            // Convert page path to lowercase (e.g., Index -> index)
            const lowercasePath = pagePath.toLowerCase();

            const page = await resolvePageComponent(
                `../../modules/${capitalizedModule}/resources/views/${lowercasePath}.vue`,
                import.meta.glob('../../modules/*/resources/views/**/*.vue', { eager: true })
            );

            // Set default layout based on module
            // Auth pages use GuestLayout (no sidebar/navbar)
            // Other pages use MainLayout
            if (!page.default.layout) {
                page.default.layout = module.toLowerCase() === 'auth' ? GuestLayout : MainLayout;
            }
            return page;
        }

        // Default app pages - lazy loaded
        const page = await resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue', { eager: true })
        );

        page.default.layout = page.default.layout || MainLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        // Page resolver for modal plugin
        const resolveModulePage = async (name) => {
            if (name.includes('::')) {
                const [module, pagePath] = name.split('::');
                const capitalizedModule = module.charAt(0).toUpperCase() + module.slice(1);
                const lowercasePath = pagePath.toLowerCase();
                return await resolvePageComponent(
                    `../../modules/${capitalizedModule}/resources/views/${lowercasePath}.vue`,
                    import.meta.glob('../../modules/*/resources/views/**/*.vue')
                );
            }
            return await resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob('./Pages/**/*.vue')
            );
        };

        app.use(plugin)
           .use(ZiggyVue)
           .use(modal, { resolve: resolveModulePage });

        // Register Global Layouts
        app.component('MainLayout', MainLayout);
        app.component('GuestLayout', GuestLayout);

        // Register Global Components (lazy loaded)
        app.component('DataTable', DataTable);
        app.component('FormInput', FormInput);
        app.component('FormSelect', FormSelect);
        app.component('FormTextarea', FormTextarea);
        app.component('Modal', Modal);
        app.component('Alert', Alert);
        app.component('Pagination', Pagination);
        app.component('Button', Button);
        app.component('Card', Card);

        return app.mount(el);
    },
    progress: {
        color: '#696cff',
        delay: 250,
        includeCSS: true,
        showSpinner: false, // Disable spinner for better performance
    },
});

// Inertia Progress Bar - optimized
InertiaProgress.init({
    delay: 250,
    color: '#696cff',
    includeCSS: true,
    showSpinner: false,
});