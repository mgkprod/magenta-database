import '../css/app.css';

import { createApp, h } from 'vue/dist/vue.esm-bundler'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
import moment from 'moment';
import momentDurationFormatSetup from 'moment-duration-format';
import axios from 'axios';
import markdownit from 'markdown-it'
import VueLoadImage from 'vue-load-image';
import PrimeVue from 'primevue/config';
import Theme from './theme';
import VueClickAway from "vue3-click-away";

momentDurationFormatSetup(moment);
moment.locale('fr');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

function resolvePageComponent(name, pages) {
  for (const path in pages) {
    if (path.endsWith(`${name.replace('.', '/')}.vue`)) {
      return typeof pages[path] === 'function' ? pages[path]() : pages[path]
    }
  }

  throw new Error(`Page not found: ${name}`)
}

createInertiaApp({
  title: (title) => import.meta.env.VITE_APP_NAME + ` » ${title}`,
  progress: { color: '#BB96F8', includeCSS: true },
  resolve: (name) => resolvePageComponent(name, import.meta.glob('./pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    const Vue = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(PrimeVue, {
          unstyled: true,
          pt: Theme,
      })
      .use(VueClickAway)

      const components = {
        ...import.meta.glob('./components/**/*.vue', {eager: true }),
      }

      Object.entries(components).forEach(([path, definition]) => {
        const componentName = path
          .split('/')
          .pop()
          .replace(/\.\w+$/, '')

        Vue.component(componentName, definition.default)
      })

    Vue.component('inertia-link', Link);
    Vue.component('Link', Link)
    Vue.component('inertia-head', Head);
    Vue.component('Head', Head)
    Vue.component('VueLoadImage', VueLoadImage)
    // Vue.component('Icon', Icon)

    Vue.config.globalProperties.axios = axios
    Vue.config.globalProperties.moment = moment
    Vue.config.globalProperties.route = window.route
    Vue.config.globalProperties.markdownit = markdownit()

    return Vue.mount(el)
  },
})

const vh = function vh() {
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', ''.concat(vh, 'px'));
};

window.addEventListener('resize', vh);
vh();
