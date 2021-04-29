// Initialize VUE
window.Vue = require('vue');

import { store } from './plugins/store';

import axios from './plugins/axios';
Vue.use(axios);

import VueSwal from 'vue-swal';
Vue.use(VueSwal);

// Components PUBLIC:
Vue.component('login', () => import(/* webpackChunkName: "login" */ './components/public/Login.vue'));

// Components UTIL:
Vue.component('paginator', () => import(/* webpackChunkName: "paginator" */ './components/util/Paginator.vue'));

// Components ADMIN:
Vue.component('user-dropdown', () => import(/* webpackChunkName: "user-dropdown" */ './components/admin/template/UserDropdown.vue'));
Vue.component('sidebar', () => import(/* webpackChunkName: "sidebar" */ './components/admin/template/SideBar.vue'));
Vue.component('customers-list', () => import(/* webpackChunkName: "customers-list" */ './components/admin/CustomersList.vue'));
Vue.component('customers-modal', () => import(/* webpackChunkName: "customers-modal" */ './components/admin/CustomersModal.vue'));
Vue.component('numbers-list', () => import(/* webpackChunkName: "numbers-list" */ './components/admin/NumbersList.vue'));
Vue.component('numbers-modal', () => import(/* webpackChunkName: "numbers-modal" */ './components/admin/NumbersModal.vue'));
Vue.component('numbers-preferences-list', () => import(/* webpackChunkName: "numbers-preferences-list" */ './components/admin/NumbersPreferencesList.vue'));
Vue.component('numbers-preferences-modal', () => import(/* webpackChunkName: "numbers-preferences-modal" */ './components/admin/NumbersPreferencesModal.vue'));
Vue.component('users-list', () => import(/* webpackChunkName: "users-list" */ './components/admin/UsersList.vue'));
Vue.component('users-modal', () => import(/* webpackChunkName: "users-modal" */ './components/admin/UsersModal.vue'));
Vue.component('levels-list', () => import(/* webpackChunkName: "levels-list" */ './components/admin/LevelsList.vue'));
Vue.component('levels-modal', () => import(/* webpackChunkName: "levels-modal" */ './components/admin/LevelsModal.vue'));

new Vue({
    el: '#app',
    store
});