// Initialize VUE
window.Vue = require('vue');

import axios from './plugins/axios.js';
Vue.use(axios);

import VueSwal from 'vue-swal';
Vue.use(VueSwal);

// Components PUBLIC:
Vue.component('login', () => import(/* webpackChunkName: "login" */ './components/public/Login.vue'));

// Components UTIL:
Vue.component('paginator', () => import(/* webpackChunkName: "paginator" */ './components/util/Paginator.vue'));

// Components ADMIN:
Vue.component('sidebar', () => import(/* webpackChunkName: "sidebar" */ './components/admin/template/SideBar.vue'));
Vue.component('customers-list', () => import(/* webpackChunkName: "customers-list" */ './components/admin/CustomersList.vue'));
Vue.component('numbers-list', () => import(/* webpackChunkName: "numbers-list" */ './components/admin/NumbersList.vue'));

new Vue({
    el: '#app'
});