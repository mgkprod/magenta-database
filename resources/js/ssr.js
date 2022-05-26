import Vue from 'vue';
import { createRenderer } from 'vue-server-renderer';
import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue';
import createServer from '@inertiajs/server';
import VueSimpleMarkdown from 'vue-simple-markdown';
import { ZiggyVue } from 'ziggy';
import { Ziggy } from './ziggy';
import moment from 'moment';
import momentDurationFormatSetup from 'moment-duration-format';
import axios from 'axios';
const _ = require('lodash');

momentDurationFormatSetup(moment);
moment.locale('fr');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.config.productionTip = false;

Vue.prototype.moment = moment;
Vue.prototype._ = _;
Vue.prototype.axios = axios;

Vue.use(ZiggyVue, Ziggy);
Vue.use(VueSimpleMarkdown);

Vue.component('inertia-head', Head);
Vue.component('inertia-link', Link);

// let global_data = new Vue({
//   data: {
//     $curr_song_id: undefined,
//     $curr_media_id: undefined,
//   },
// });

// Vue.mixin({
//   computed: {
//     $curr_song_id: {
//       get: function () {
//         return global_data.$data.$curr_song_id;
//       },
//       set: function (new_song_id) {
//         global_data.$data.$curr_song_id = new_song_id;
//       },
//     },
//     $curr_media_id: {
//       get: function () {
//         return global_data.$data.$curr_media_id;
//       },
//       set: function (new_song_id) {
//         global_data.$data.$curr_media_id = new_song_id;
//       },
//     },
//   },
// });

const files = require.context('./', true, /\.vue$/i);
files.keys().map((key) => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

createServer((page) =>
  createInertiaApp({
    page,
    render: createRenderer().renderToString,
    resolve: (name) => require(`./pages/${name}`),
    title: (title) => `MAGENTA-DATABASE » ${title}`,
    setup({ app, props, plugin }) {
      Vue.use(plugin);

      return new Vue({
        render: (h) => h(app, props),
      });
    },
  }),
);
