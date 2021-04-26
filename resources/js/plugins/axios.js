import axios from 'axios';

const instance = axios.create({});
const MAX_REQUESTS_COUNT = 5;
const INTERVAL_MS = 10000;
let PENDING_REQUESTS = 0;

// Controls the maximum number of requests in the range
instance.interceptors.request.use(function (config) {
    return new Promise((resolve, reject) => {
        let interval = setInterval(() => {
            if (PENDING_REQUESTS < MAX_REQUESTS_COUNT) {
                PENDING_REQUESTS++;
                clearInterval(interval);
                resolve(config);
            } 
        }, INTERVAL_MS);
    })
});

instance.interceptors.response.use(function (response) {
    PENDING_REQUESTS = Math.max(0, PENDING_REQUESTS - 1);
    return Promise.resolve(response);
}, function (error) {
    PENDING_REQUESTS = Math.max(0, PENDING_REQUESTS - 1);
    return Promise.reject(error);
});

instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    instance.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('axios.js -> CSRF token not found(resources/js/bootstrap.js): https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

export default {
    install (Vue, options) {
        Vue.prototype.$axios = instance
    }
}