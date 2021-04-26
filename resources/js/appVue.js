// Initialize VUE
window.Vue = require('vue');

import axios from './plugins/axios.js';
Vue.use(axios);

import VueSwal from 'vue-swal';
Vue.use(VueSwal);

// Components PUBLIC:
Vue.component('login', () => import(/* webpackChunkName: "login" */ './components/public/Login.vue'));

// Components UTIL:
Vue.component('text', () => import(/* webpackChunkName: "text" */ './components/util/Text.vue'));
Vue.component('datatable', () => import(/* webpackChunkName: "datatable" */ './components/util/Datatable.vue'));

// Components ADMIN:
Vue.component('customers-list', () => import(/* webpackChunkName: "customers-list" */ './components/admin/CustomersList.vue'));
Vue.component('numbers-list', () => import(/* webpackChunkName: "numbers-list" */ './components/admin/NumbersList.vue'));

new Vue({
    el: '#app'
});