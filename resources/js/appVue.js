// Initialize VUE
window.Vue = require('vue');

import axios from './plugins/axios.js';
Vue.use(axios);

import helpers from './plugins/helpers.js';
Vue.use(helpers);

import VueSwal from 'vue-swal';
Vue.use(VueSwal);

Vue.component('text', () => import(/* webpackChunkName: "text" */ './components/util/Text.vue'));

new Vue({
    el: '#app_content'
});