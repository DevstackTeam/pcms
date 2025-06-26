import { createApp, h } from 'vue'
import { createInertiaApp, Head } from '@inertiajs/vue3'

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css';

import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import 'bootstrap-icons/font/bootstrap-icons.css'
import '../css/custom-bootstrap.css'

const vuetify = createVuetify({
  components,
  directives,
  theme: {
    defaultTheme: 'bootstrap',
    themes: {
      bootstrap: {
        dark: false,
        colors: {
          primary: '#00ADB5',

        },
      },
    },
  },
})


createInertiaApp({
  title: (title) => `PCMS ${title}`,
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(vuetify)
      .component('Head', Head)
      .mount(el)
  },
})
