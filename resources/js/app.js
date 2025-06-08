import { createApp, h } from 'vue'
import { createInertiaApp, Head } from '@inertiajs/vue3'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import '../css/custom-bootstrap.css'
import 'bootstrap-icons/font/bootstrap-icons.css'

createInertiaApp({
    title: (title) => `PCMS ${title}`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('Head', Head)
            .mount(el)
    },
})
