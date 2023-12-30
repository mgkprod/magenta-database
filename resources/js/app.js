import '../css/app.css';

import Vue from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue';
import { InertiaProgress } from '@inertiajs/progress/src';
import moment from 'moment';
import momentDurationFormatSetup from 'moment-duration-format';
import axios from 'axios';
import lodash from 'lodash';
import markdownit from 'markdown-it'

momentDurationFormatSetup(moment);
moment.locale('fr');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.config.productionTip = false;

Vue.prototype._ = lodash;
Vue.prototype.moment = moment;
Vue.prototype.axios = axios;
Vue.prototype.route = window.route;
Vue.prototype.markdownit = markdownit();

// Vue.use(VueMarkdown);

Vue.component('inertia-link', Link);
Vue.component('inertia-head', Head);

InertiaProgress.init();

let global_data = new Vue({
  data: {
    $curr_song_id: undefined,
    $curr_media_id: undefined,
  },
});

Vue.mixin({
  computed: {
    $curr_song_id: {
      get: function () {
        return global_data.$data.$curr_song_id;
      },
      set: function (new_song_id) {
        global_data.$data.$curr_song_id = new_song_id;
      },
    },
    $curr_media_id: {
      get: function () {
        return global_data.$data.$curr_media_id;
      },
      set: function (new_song_id) {
        global_data.$data.$curr_media_id = new_song_id;
      },
    },
  },
});

function resolvePageComponent(name, pages) {
  for (const path in pages) {
    if (path.endsWith(`${name.replace('.', '/')}.vue`)) {
      return typeof pages[path] === 'function' ? pages[path]() : pages[path]
    }
  }

  throw new Error(`Page not found: ${name}`)
}


// const files = require.context('./', true, /\.vue$/i);
// files.keys().map((key) => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const components = {
  ...import.meta.globEager('./components/**/*.vue'),
}

Object.entries(components).forEach(([path, definition]) => {
  const componentName = path
    .split('/')
    .pop()
    .replace(/\.\w+$/, '')

  Vue.component(componentName, definition.default)
})

createInertiaApp({
  resolve: (name) => resolvePageComponent(name, import.meta.glob('./pages/**/*.vue')),
  title: (title) => import.meta.env.VITE_APP_NAME + ` » ${title}`,
  setup({ el, App, props, plugin }) {
    Vue.use(plugin);

    new Vue({
      render: (h) => h(App, props),
    }).$mount(el);
  },
});

const vh = function vh() {
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', ''.concat(vh, 'px'));
};

window.addEventListener('resize', vh);
vh();
