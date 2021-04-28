window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = jQuery = require('jquery');
} catch (e) {
    console.error('compile scss error', e);
}

require('bootstrap');

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('resources\js\bootstrap.js -> CSRF token not found(resources/js/bootstrap.js): https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

