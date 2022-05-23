//import './bootstrap';
import Vue from 'vue';
import { createRenderer } from 'vue-server-renderer';
import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue';
import createServer from '@inertiajs/server';
import VueSimpleMarkdown from 'vue-simple-markdown';
import route from 'ziggy';
import { ZiggyVue } from 'ziggy';
import { Ziggy } from './ziggy';

import moment from 'moment';
import momentDurationFormatSetup from 'moment-duration-format';
momentDurationFormatSetup(moment);

Vue.config.productionTip = false;

moment.locale('fr');

// Vue.prototype._ = window._;
Vue.prototype.moment = moment;

// Vue.use(ZiggyVue);
Vue.use(VueSimpleMarkdown);
Vue.component('inertia-head', Head);
Vue.component('inertia-link', Link);

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

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i);
files.keys().map((key) => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// const el = document.getElementById('app');

// new Vue({
//   render: (h) =>
//     h(App, {
//       props: {
//         initialPage: JSON.parse(el.dataset.page),
//         resolveComponent: (name) => require(`./pages/${name}`).default,
//       },
//     }),
// }).$mount(el);

createServer((page) =>
  createInertiaApp({
    page,
    render: createRenderer().renderToString,
    resolve: (name) => require(`./pages/${name}`),
    setup({ app, props, plugin }) {
      //   const Ziggy = {
      //     // Pull the Ziggy config off of the props.
      //     ...props.initialPage.props.ziggy,
      //     // Build the location, since there is
      //     // no window.location in Node.
      //     location: new URL(props.initialPage.props.ziggy.url),
      //   };

      Vue.use(plugin);

      //   Vue.mixin({
      //     methods: {
      //       route: (name, params, absolute, config = Ziggy) => route(name, params, absolute, config),
      //     },
      //   });
      Vue.use(ZiggyVue, Ziggy);

      return new Vue({
        render: (h) => h(app, props),
      });
    },
  }),
);

// var vh = function vh() {
//   var vh = window.innerHeight * 0.01;
//   document.documentElement.style.setProperty('--vh', ''.concat(vh, 'px'));
// };

// window.addEventListener('resize', vh);
// vh();
