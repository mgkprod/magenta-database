import Vue from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue';
import { InertiaProgress } from '@inertiajs/progress/src';
import VueSimpleMarkdown from 'vue-simple-markdown';
import { ZiggyVue } from 'ziggy';
import moment from 'moment';
import momentDurationFormatSetup from 'moment-duration-format';
import axios from 'axios';

const _ = require('lodash');

momentDurationFormatSetup(moment);
moment.locale('fr');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.config.productionTip = false;

Vue.prototype._ = _;
Vue.prototype.moment = moment;
Vue.prototype.axios = axios;

Vue.use(ZiggyVue);
Vue.use(VueSimpleMarkdown);

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

const files = require.context('./', true, /\.vue$/i);
files.keys().map((key) => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

createInertiaApp({
  resolve: (name) => require(`./pages/${name}`),
  title: (title) => process.env.MIX_APP_NAME + ` » ${title}`,
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
