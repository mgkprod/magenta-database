import "./bootstrap"
import Vue from 'vue'
import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress/src'
import VueSimpleMarkdown from 'vue-simple-markdown'

import moment from 'moment';
import momentDurationFormatSetup from 'moment-duration-format';
momentDurationFormatSetup(moment);

Vue.config.productionTip = false

moment.locale('fr');

Vue.prototype._ = window._
Vue.prototype.moment = moment;

Vue.mixin({ methods: {
    route: window.route,
} })

Vue.use(plugin)
Vue.use(VueSimpleMarkdown)

InertiaProgress.init()

let global_data = new Vue({
    data: {
        $curr_song_id: undefined,
        $curr_media_id: undefined,
    }
});

Vue.mixin({
    computed: {
        $curr_song_id: {
            get: function () { return global_data.$data.$curr_song_id },
            set: function (new_song_id) { global_data.$data.$curr_song_id = new_song_id; }
        },
        $curr_media_id: {
            get: function () { return global_data.$data.$curr_media_id },
            set: function (new_song_id) { global_data.$data.$curr_media_id = new_song_id; }
        }
    }
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const el = document.getElementById('app')

new Vue({
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => require(`./pages/${name}`).default,
        },
    }),
}).$mount(el)

var vh = function vh() {
    var vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', "".concat(vh, "px"));
};

window.addEventListener('resize', vh);
vh();