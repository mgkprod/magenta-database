import "./bootstrap"
import Vue from 'vue'
import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress/src'
import moment from 'moment';
import VueSimpleMarkdown from 'vue-simple-markdown'

Vue.config.productionTip = false

moment.lang('fr');

Vue.prototype._ = window._

Vue.mixin({ methods: {
    route: window.route,
    moment,
} })

Vue.use(plugin)
Vue.use(VueSimpleMarkdown)

InertiaProgress.init()

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
