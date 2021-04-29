import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        user: JSON.parse(localStorage.getItem('user'))
    },
    getters: {
        user: (state) => {
            return state.user;
        }
    },
    mutations: {
        userinfo (state, data) {
            state.user = data;
            localStorage.setItem('user', JSON.stringify(data));
        },

        clearUserData () {
            localStorage.removeItem('user')
        }
    }
});